@stylesheet('goods/css/partials/get-a-quote.css')

@php
    $airports = \App\Models\FixedPrice::select('destination_name')->distinct()->get();
@endphp
<div class="bnq-wrapper">
    <form action="{{ url('pricing') }}" method="GET" class="bnq-box">

        <div class="bnq-header">
            <h2>GET AN INSTANT QUOTE</h2>
            <div class="bnq-flag">🇬🇧 GB</div>
        </div>

        @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert" style="border-radius: 12px;">
                {{ session()->get('error') }}
            </div>
        @endif
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert" style="border-radius: 12px;">
                {{ session()->get('success') }}
            </div>
        @endif

        <!-- Pickup -->
        <div class="bnq-field bnq-auto">
            <span class="bnq-icon">
                <i class="fas fa-map" aria-hidden="true"></i>
            </span>

            <input
                type="text"
                id="pickup"
                name="pickup"
                placeholder="Enter pickup location"
                required
            >

            <span class="bnq-gear">⚙️</span>
            <div class="bnq-suggest" id="pickup-list"></div>
        </div>


        <!-- Dropoff -->
        <div class="bnq-field bnq-auto" id="dropoff-container">
            <span class="bnq-icon">
                <i class="fas fa-map" aria-hidden="true"></i>
            </span>

            <input
                type="text"
                id="dropoff"
                name="dropoff"
                placeholder="Enter dropoff location"
                required
            >

            <span class="bnq-gear">⚙️</span>
            <div class="bnq-suggest" id="dropoff-list"></div>
        </div>


        <!-- Date & Time -->
        <div class="bnq-row">

            <!-- Pickup Date -->
            <div class="bnq-field bnq-picker-field">
                <span class="bnq-icon">
                    <i class="fas fa-calendar" aria-hidden="true"></i>
                </span>

                <span
                    class="bnq-picker-text"
                    id="pickup-date-text"
                >
                    SELECT DATE
                </span>

                <input
                    type="date"
                    id="pickup-date" aria-label="Pickup date"
                    name="pickup_date"
                    required
                >
            </div>


            <!-- Pickup Time -->
            <div class="bnq-field bnq-picker-field">
                <span class="bnq-icon">
                    <i class="fas fa-clock" aria-hidden="true"></i>
                </span>

                <span
                    class="bnq-picker-text"
                    id="pickup-time-text"
                >
                    SELECT TIME
                </span>

                <input
                    type="time"
                    id="pickup-time" aria-label="Pickup time"
                    name="pickup_time"
                    required
                >
            </div>

        </div>


        <!-- Return Date & Time -->
        <div
            class="bnq-row"
            id="return-datetime-container"
            style="display:none; margin-top:15px;"
        >

            <input
                type="hidden"
                id="is_return"
                name="is_return"
                value="0"
            >


            <!-- Return Date -->
            <div class="bnq-field bnq-picker-field">

                <span class="bnq-icon">
                    <i class="fas fa-calendar" aria-hidden="true"></i>
                </span>

                <span
                    class="bnq-picker-text"
                    id="return-date-text"
                >
                    RETURN DATE
                </span>

                <input
                    type="date"
                    id="return-date" aria-label="Return date"
                    name="return_date"
                >

            </div>


            <!-- Return Time -->
            <div class="bnq-field bnq-picker-field">

                <span class="bnq-icon">
                    <i class="fas fa-clock" aria-hidden="true"></i>
                </span>

                <span
                    class="bnq-picker-text"
                    id="return-time-text"
                >
                    RETURN TIME
                </span>

                <input
                    type="time"
                    id="return-time" aria-label="Return time"
                    name="return_time"
                >

            </div>

        </div>


        <!-- Options -->
        <div class="bnq-options">

            <span
                id="add-via"
                style="cursor:pointer;"
                title="Add an extra stop"
            >
                + Via
            </span>

            <span
                id="swap-locations"
                style="cursor:pointer;"
                title="Swap Pickup and Dropoff"
            >
                ⇅
            </span>

            <span
                id="toggle-return"
                style="cursor:pointer;"
                title="Add a return journey"
            >
                Return Journey?
            </span>

        </div>


        <button type="submit" class="bnq-btn">
            Calculate Price
        </button>

    </form>
</div>


<script>
    // Google Maps (~1 MB of JS) is loaded only when the visitor starts using an address field,
    // so it no longer blocks the initial page load.
    window.bnLoadPlaces = (function () {
        let promise = null;
        return function () {
            if (promise) return promise;
            promise = new Promise(function (resolve, reject) {
                if (window.google && google.maps && google.maps.places) return resolve();
                window.__bnPlacesReady = resolve;
                const s = document.createElement('script');
                s.src = "https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=places&loading=async&callback=__bnPlacesReady";
                s.async = true;
                s.onerror = reject;
                document.head.appendChild(s);
            });
            return promise;
        };
    })();

    function setupAutocomplete(inputId, listId) {
        const input = document.getElementById(inputId);
        const box = document.getElementById(listId);

        if (!input) {
            console.log("ID not found:", inputId);
            return;
        }

        // Hide custom suggestion box since Google provides its own UI
        if (box) {
            box.style.display = "none";
        }

        if (!(window.google && google.maps && google.maps.places)) {
            // Attach once the visitor focuses/touches the field (or immediately if Maps is already loading).
            const start = function () {
                input.removeEventListener('focus', start);
                input.removeEventListener('pointerdown', start);
                bnLoadPlaces().then(function () { setupAutocomplete(inputId, listId); })
                    .catch(function () { console.error("Google Maps Places API failed to load."); });
            };
            input.addEventListener('focus', start);
            input.addEventListener('pointerdown', start);
            return;
        }

        if (input.dataset.placesBound) return;
        input.dataset.placesBound = '1';

        if (typeof google !== "undefined" && google.maps && google.maps.places) {
            const autocomplete = new google.maps.places.Autocomplete(input, {
                componentRestrictions: { country: "gb" }, // Restrict results to the UK
                fields: ["formatted_address", "name"],
            });

            autocomplete.addListener("place_changed", () => {
                const place = autocomplete.getPlace();
                if (place.formatted_address) {
                    input.value = place.formatted_address;
                } else if (place.name) {
                    input.value = place.name;
                }
            });

            // Prevent form submission when pressing Enter inside the autocomplete dropdown
            input.addEventListener("keydown", function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                }
            });
        } else {
            console.error("Google Maps Places API not loaded.");
        }
    }

    // INIT (IMPORTANT)
    document.addEventListener("DOMContentLoaded", function () {
        setupAutocomplete("pickup", "pickup-list");
        setupAutocomplete("dropoff", "dropoff-list");

        // Swap locations (Reverse)
        document.getElementById('swap-locations').addEventListener('click', function() {
            const pickup = document.getElementById('pickup');
            const dropoff = document.getElementById('dropoff');
            const temp = pickup.value;
            pickup.value = dropoff.value;
            dropoff.value = temp;
        });

        // Toggle Return Journey
        document.getElementById('toggle-return').addEventListener('click', function() {
            const returnContainer = document.getElementById('return-datetime-container');
            const isReturnInput = document.getElementById('is_return');
            if (returnContainer.style.display === 'none' || returnContainer.style.display === '') {
                returnContainer.style.display = 'flex';
                if (isReturnInput) isReturnInput.value = '1';
                this.style.fontWeight = 'bold';
                this.style.color = '#267fca'; // Highlight option
            } else {
                returnContainer.style.display = 'none';
                if (isReturnInput) isReturnInput.value = '0';
                this.style.fontWeight = 'normal';
                this.style.color = '';
                document.getElementById('return-date').value = '';
                document.getElementById('return-time').value = '';
            }
        });

        // Add Via (Extra stops)
        let viaCount = 0;
        document.getElementById('add-via').addEventListener('click', function() {
            viaCount++;
            const dropoffContainer = document.getElementById('dropoff-container');
            
            const viaDiv = document.createElement('div');
            viaDiv.className = 'bnq-field bnq-auto';
            viaDiv.style.marginBottom = '15px'; 
            viaDiv.innerHTML = `
                <span class="bnq-icon"><i class="fas fa-map" aria-hidden="true"></i></span>
                <input type="text" id="via-${viaCount}" name="via[]" placeholder="Enter via location">
                <span class="bnq-gear" style="cursor:pointer;" onclick="this.parentElement.remove()" title="Remove Stop">❌</span>
                <div class="bnq-suggest" id="via-${viaCount}-list"></div>
            `;
            
            dropoffContainer.parentNode.insertBefore(viaDiv, dropoffContainer);
            setupAutocomplete(`via-${viaCount}`, `via-${viaCount}-list`);
        });

        // Date and Time Validation
        const pickupDate = document.getElementById('pickup-date');
        const pickupTime = document.getElementById('pickup-time');
        const returnDate = document.getElementById('return-date');
        const returnTime = document.getElementById('return-time');

        const formatDate = (date) => {
            let month = '' + (date.getMonth() + 1);
            let day = '' + date.getDate();
            const year = date.getFullYear();
            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;
            return [year, month, day].join('-');
        };

        const today = formatDate(new Date());
        pickupDate.min = today;
        returnDate.min = today;

        const validateTime = () => {
            const currentDate = new Date();
            const currentToday = formatDate(currentDate);
            
            let currentHours = currentDate.getHours().toString().padStart(2, '0');
            let currentMinutes = currentDate.getMinutes().toString().padStart(2, '0');
            const currentTime = `${currentHours}:${currentMinutes}`;

            // Prevent past times if booking for today
            if (pickupDate.value === currentToday) {
                pickupTime.min = currentTime;
                if (pickupTime.value && pickupTime.value < currentTime) pickupTime.value = currentTime;
            } else {
                pickupTime.min = '';
            }

            // Prevent past times on return journey, and ensure it happens after pickup time
            if (returnDate.value === currentToday) {
                returnTime.min = currentTime;
                if (returnTime.value && returnTime.value < currentTime) returnTime.value = currentTime;
            } else if (returnDate.value === pickupDate.value && pickupTime.value) {
                returnTime.min = pickupTime.value;
                if (returnTime.value && returnTime.value < pickupTime.value) returnTime.value = pickupTime.value;
            } else {
                returnTime.min = '';
            }
        };

        const updateText = (inputEl, textElId, defaultText) => {
            const textEl = document.getElementById(textElId);
            if (textEl) {
                if (inputEl.value) {
                    textEl.innerText = inputEl.value;
                } else {
                    textEl.innerText = defaultText;
                }
            }
        };

        // Attach click listeners to picker fields to ensure reliable click/tap response
        document.querySelectorAll('.bnq-picker-field').forEach(field => {
            field.addEventListener('click', (e) => {
                const input = field.querySelector('input');
                if (input && typeof input.showPicker === 'function') {
                    try {
                        input.showPicker();
                    } catch (err) {
                        console.log(err);
                    }
                }
            });
        });

        pickupDate.addEventListener('change', () => {
            updateText(pickupDate, 'pickup-date-text', 'SELECT DATE');
            // Ensure return date is always equal to or after pickup date
            returnDate.min = pickupDate.value || today;
            if (returnDate.value && returnDate.value < pickupDate.value) {
                returnDate.value = pickupDate.value;
                updateText(returnDate, 'return-date-text', 'RETURN DATE');
            }
            validateTime();
        });
        
        pickupTime.addEventListener('input', () => {
            updateText(pickupTime, 'pickup-time-text', 'SELECT TIME');
            validateTime();
        });

        returnDate.addEventListener('change', () => {
            updateText(returnDate, 'return-date-text', 'RETURN DATE');
            validateTime();
        });

        returnTime.addEventListener('input', () => {
            updateText(returnTime, 'return-time-text', 'RETURN TIME');
            validateTime();
        });

        // Initialize display text if values are prefilled or change dynamically
        updateText(pickupDate, 'pickup-date-text', 'SELECT DATE');
        updateText(pickupTime, 'pickup-time-text', 'SELECT TIME');
        updateText(returnDate, 'return-date-text', 'RETURN DATE');
        updateText(returnTime, 'return-time-text', 'RETURN TIME');
    });
</script>