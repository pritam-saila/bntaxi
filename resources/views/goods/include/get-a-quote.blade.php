<style>
/* =========================================================
   BN TAXI - INSTANT QUOTE
   STANDARD HEAVY / PREMIUM ROYAL BLUE + WHITE
   Dynamic-safe: Via / Return / Google Places
   ========================================================= */

.bnq-wrapper,
.bnq-wrapper *{box-sizing:border-box}

.bnq-wrapper{
    width:100%;
    min-height:100%;
    padding:42px 16px 58px;
    display:flex;
    justify-content:center;
    align-items:flex-start;
    position:relative;
    overflow:hidden;
    font-family:"Poppins",Arial,sans-serif;
    background:
        radial-gradient(circle at 9% 10%,rgba(255,255,255,.72) 0 3px,transparent 4px),
        radial-gradient(circle at 92% 17%,rgba(255,255,255,.58) 0 3px,transparent 4px),
        radial-gradient(circle at 86% 4%,rgba(21,87,214,.08) 0 150px,transparent 151px),
        linear-gradient(135deg,#e7f2ff 0%,#f7faff 52%,#e9f3ff 100%);
}

.bnq-wrapper:before{
    content:"";
    position:absolute;
    width:390px;height:390px;
    right:-220px;top:-230px;
    border:58px solid rgba(21,87,214,.065);
    border-radius:50%;
    pointer-events:none;
}

.bnq-wrapper:after{
    content:"";
    position:absolute;
    width:300px;height:300px;
    left:-205px;bottom:-205px;
    border:48px solid rgba(21,87,214,.055);
    border-radius:50%;
    pointer-events:none;
}

.bnq-box{
    width:100%;
    max-width:800px;
    margin:0 auto;
    padding:0 30px 30px;
    background:#fff;
    border:1px solid rgba(21,87,214,.12);
    border-radius:24px;
    box-shadow:
        0 24px 55px rgba(8,47,125,.17),
        0 6px 18px rgba(8,47,125,.07);
    position:relative;
    z-index:2;
}

/* subtle blue edge */
.bnq-box:before{
    content:"";
    position:absolute;
    left:0;right:0;top:0;
    height:4px;
    border-radius:24px 24px 0 0;
    background:linear-gradient(90deg,#082f7d,#1557d6,#082f7d);
}

.bnq-header{
    margin:0 -30px 24px;
    padding:23px 30px;
    min-height:84px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:16px;
    background:
        radial-gradient(circle at 38% 0%,rgba(255,255,255,.13),transparent 180px),
        linear-gradient(135deg,#082f7d 0%,#1557d6 55%,#0b3d9e 100%);
    border-radius:24px 24px 0 0;
    position:relative;
    overflow:hidden;
}

.bnq-header:before{
    content:"";
    position:absolute;
    width:220px;height:170px;
    left:23%;top:-80px;
    background:rgba(255,255,255,.08);
    transform:rotate(22deg);
    border-radius:50%;
    pointer-events:none;
}

.bnq-header:after{
    content:"";
    position:absolute;
    width:190px;height:190px;
    right:-105px;top:-120px;
    border:28px solid rgba(255,255,255,.07);
    border-radius:50%;
    pointer-events:none;
}

.bnq-header h2{
    margin:0;
    color:#fff;
    font-size:clamp(25px,3vw,32px);
    line-height:1.1;
    font-weight:800;
    letter-spacing:.2px;
    text-transform:uppercase;
    position:relative;
    z-index:1;
}

.bnq-flag{
    flex:0 0 auto;
    color:#fff;
    font-size:17px;
    font-weight:800;
    white-space:nowrap;
    position:relative;
    z-index:1;
}

/* fields */
.bnq-field{
    width:100%;
    min-width:0;
    min-height:64px;
    margin-bottom:14px;
    display:flex;
    align-items:center;
    position:relative;
    background:#fff;
    border:1.7px solid #172033;
    border-radius:13px;
    transition:border-color .2s ease,box-shadow .2s ease,transform .2s ease;
}

.bnq-field:hover{
    border-color:#1557d6;
}

.bnq-field:focus-within{
    border-color:#1557d6;
    box-shadow:0 0 0 3px rgba(21,87,214,.10);
}

.bnq-icon{
    width:52px;height:52px;
    margin-left:8px;margin-right:11px;
    flex:0 0 52px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#0a0d14;
    color:#fff;
    border-radius:10px;
    font-size:19px;
}

.bnq-icon i{color:#fff!important}

.bnq-auto .bnq-icon{
    background:linear-gradient(135deg,#1557d6,#0b3d9e);
}

.bnq-field input{
    width:100%;
    min-width:0;
    height:62px;
    padding:0 55px 0 0;
    border:0!important;
    outline:0!important;
    box-shadow:none!important;
    background:transparent!important;
    color:#101828;
    font-family:inherit;
    font-size:15px;
    font-weight:700;
    appearance:none;
    -webkit-appearance:none;
}

.bnq-field input::placeholder{
    color:#263247;
    opacity:1;
    font-weight:650;
}

.bnq-field input[type=date],
.bnq-field input[type=time]{cursor:pointer}

.bnq-field input[type=date]::-webkit-calendar-picker-indicator,
.bnq-field input[type=time]::-webkit-calendar-picker-indicator{
    cursor:pointer;
    opacity:1;
    width:18px;height:18px;
}

/* right location icon */
.bnq-gear{
    position:absolute;
    right:15px;
    top:50%;
    transform:translateY(-50%);
    width:31px;height:31px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#1557d6;
    font-size:0;
    cursor:pointer;
    z-index:3;
}

.bnq-auto>.bnq-gear:before{
    content:"";
    width:18px;height:18px;
    border:3.5px solid #1557d6;
    border-radius:50%;
    box-shadow:
        0 -10px 0 -7px #1557d6,
        0 10px 0 -7px #1557d6,
        10px 0 0 -7px #1557d6,
        -10px 0 0 -7px #1557d6;
}

.bnq-field .bnq-gear[title="Remove Stop"]{
    font-size:0!important;
}

.bnq-field .bnq-gear[title="Remove Stop"]:before{
    content:"×";
    width:29px;height:29px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#fff2f4;
    color:#e11d48;
    border:1px solid #fecdd3;
    border-radius:50%;
    font-size:21px;
    font-weight:700;
}

/* date / time */
.bnq-row{
    width:100%;
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:14px;
}

.bnq-row .bnq-field{min-width:0}

#return-datetime-container{
    width:100%;
}

.bnq-picker-field{
    position:relative!important;
    overflow:hidden!important;
    cursor:pointer;
}

.bnq-picker-text{
    flex:1;
    min-width:0;
    display:flex;
    align-items:center;
    padding-right:48px;
    color:#172033;
    font-size:14px;
    font-weight:750;
    line-height:1.2;
    white-space:nowrap;
    position:relative;
    z-index:3;
    pointer-events:none;
}

.bnq-picker-field input[type=date],
.bnq-picker-field input[type=time]{
    position:absolute!important;
    top:0!important;left:0!important;
    width:100%!important;height:100%!important;
    margin:0!important;padding:0!important;
    border:0!important;outline:0!important;
    opacity:0!important;
    cursor:pointer!important;
    z-index:10!important;
    -webkit-appearance:auto!important;
    appearance:auto!important;
}

.bnq-picker-field .bnq-icon{
    position:relative;
    z-index:4;
    pointer-events:none;
}

.bnq-picker-field:after{
    content:"";
    position:absolute;
    right:20px;
    top:50%;
    width:9px;height:9px;
    border-right:2.5px solid #172033;
    border-bottom:2.5px solid #172033;
    transform:translateY(-70%) rotate(45deg);
    z-index:8;
    pointer-events:none;
}

/* options */
.bnq-options{
    width:100%;
    min-height:58px;
    margin:2px 0 16px;
    padding:8px 13px;
    display:flex;
    align-items:center;
    background:#f7fbff;
    border:1.5px solid #b8d5f5;
    border-radius:12px;
    color:#172033;
}

#add-via{
    padding-right:15px;
    color:#1557d6;
    font-size:14px;
    font-weight:800;
    white-space:nowrap;
}

#swap-locations{
    min-width:50px;
    padding:0 14px;
    display:inline-flex;
    justify-content:center;
    align-items:center;
    border-left:1px solid #c7d3e2;
    color:#1557d6;
    font-size:24px;
    font-weight:800;
    line-height:1;
}

#toggle-return{
    flex:1;
    min-height:38px;
    padding-left:13px;
    display:flex;
    align-items:center;
    position:relative;
    color:#172033!important;
    font-size:14px;
    font-weight:750!important;
    white-space:nowrap;
    cursor:pointer;
}

#toggle-return:after{
    content:"";
    width:50px;height:28px;
    margin-left:auto;
    flex:0 0 50px;
    background:#cbd5e1;
    border:2px solid #94a3b8;
    border-radius:999px;
    box-shadow:
        inset 22px 0 0 -3px #fff,
        0 2px 5px rgba(0,0,0,.10);
    transition:.25s ease;
}

#toggle-return[style*="color"]:after{
    background:#1557d6;
    border-color:#1557d6;
    box-shadow:
        inset -22px 0 0 -3px #fff,
        0 2px 7px rgba(21,87,214,.25);
}

/* calculate button */
.bnq-btn{
    width:100%;
    min-height:60px;
    padding:13px 62px 13px 22px;
    position:relative;
    border:0;
    border-radius:12px;
    background:linear-gradient(135deg,#1557d6 0%,#0b3d9e 100%);
    color:#fff;
    font-family:inherit;
    font-size:18px;
    font-weight:800;
    text-transform:uppercase;
    letter-spacing:.2px;
    cursor:pointer;
    box-shadow:0 10px 22px rgba(21,87,214,.25);
    transition:transform .2s ease,box-shadow .2s ease,background .2s ease;
}

.bnq-btn:after{
    content:"→";
    position:absolute;
    right:22px;
    top:50%;
    transform:translateY(-53%);
    font-size:29px;
    font-weight:400;
    line-height:1;
}

.bnq-btn:hover{
    transform:translateY(-2px);
    background:linear-gradient(135deg,#0b3d9e,#082f7d);
    box-shadow:0 14px 27px rgba(21,87,214,.30);
}

.bnq-btn:active{transform:translateY(0)}

/* alerts */
.bnq-box .alert{
    border-radius:10px;
}

/* Google suggestions */
.pac-container{
    z-index:999999!important;
    border:0!important;
    border-radius:10px!important;
    margin-top:5px;
    overflow:hidden;
    font-family:"Poppins",Arial,sans-serif!important;
    box-shadow:0 12px 35px rgba(0,0,0,.18)!important;
}

.pac-item{
    min-height:46px;
    padding:7px 11px!important;
    cursor:pointer;
}

.pac-item:hover{background:#f2f7ff}

/* tablet */
@media(max-width:768px){
    .bnq-wrapper{padding:30px 12px 45px}

    .bnq-box{
        max-width:650px;
        padding:0 22px 24px;
        border-radius:21px;
    }

    .bnq-header{
        margin:0 -22px 19px;
        padding:20px 22px;
        min-height:78px;
        border-radius:21px 21px 0 0;
    }

    .bnq-header h2{font-size:25px}

    .bnq-field{
        min-height:60px;
        margin-bottom:12px;
    }

    .bnq-icon{
        width:49px;height:49px;
        flex-basis:49px;
        margin-left:7px;
        margin-right:9px;
        font-size:18px;
    }

    .bnq-field input{
        height:58px;
        font-size:14px;
    }

    .bnq-btn{
        min-height:58px;
        font-size:17px;
    }
}

/* mobile */
@media(max-width:575.98px){
    .bnq-wrapper{
        padding:20px 8px 34px;
    }

    .bnq-box{
        max-width:100%;
        padding:0 14px 18px;
        border-radius:17px;
    }

    .bnq-header{
        margin:0 -14px 15px;
        padding:17px 14px;
        min-height:68px;
        border-radius:17px 17px 0 0;
    }

    .bnq-header h2{
        font-size:clamp(18px,5.5vw,23px);
    }

    .bnq-flag{font-size:14px}

    .bnq-field{
        min-height:58px;
        margin-bottom:11px;
        border-width:1.6px;
        border-radius:11px;
    }

    .bnq-icon{
        width:44px;height:44px;
        flex:0 0 44px;
        margin-left:6px;
        margin-right:8px;
        border-radius:8px;
        font-size:17px;
    }

    .bnq-field input{
        height:54px;
        padding-right:0;
        color:#000!important;
        font-size:13px;
    }

    .bnq-field input::placeholder{font-size:13px}

    .bnq-gear{
        right:9px;
        width:27px;height:27px;
    }

    .bnq-auto>.bnq-gear:before{
        width:16px;height:16px;
        border-width:3px;
    }

    .bnq-row{
        grid-template-columns:1fr;
        gap:0;
    }

    #return-datetime-container{
        flex-direction:column!important;
        gap:0;
    }

    .bnq-options{
        min-height:55px;
        padding:7px 8px;
        margin-bottom:13px;
        border-radius:10px;
    }

    #add-via{
        padding-right:8px;
        font-size:13px;
    }

    #swap-locations{
        min-width:37px;
        padding:0 7px;
        font-size:21px;
    }

    #toggle-return{
        padding-left:7px;
        font-size:12px;
    }

    #toggle-return:after{
        width:43px;height:25px;
        flex-basis:43px;
    }

    .bnq-btn{
        min-height:56px;
        padding:11px 50px 11px 16px;
        border-radius:10px;
        font-size:16px;
    }

    .bnq-btn:after{
        right:17px;
        font-size:27px;
    }

    .bnq-picker-text{
        padding-right:44px!important;
        font-size:13px;
    }

    .bnq-picker-field:after{
        right:17px;
        width:8px;height:8px;
    }
}

/* very small */
@media(max-width:380px){
    .bnq-box{
        padding-left:11px;
        padding-right:11px;
    }

    .bnq-header{
        margin-left:-11px;
        margin-right:-11px;
        padding-left:12px;
        padding-right:12px;
    }

    .bnq-header h2{font-size:17px}
    .bnq-flag{font-size:12px}

    .bnq-icon{
        width:41px;height:41px;
        flex-basis:41px;
    }

    .bnq-field input,
    .bnq-field input::placeholder{font-size:12px}

    #add-via{font-size:11.5px}
    #toggle-return{font-size:10.5px}

    #toggle-return:after{
        width:38px;height:23px;
        flex-basis:38px;
    }

    .bnq-btn{font-size:15px}
}

/* date/time mobile */
@media(max-width:575.98px){
    .bnq-picker-text{
        font-size:13px;
        font-weight:700;
    }
}
</style>

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
                    id="pickup-date"
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
                    id="pickup-time"
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
                    id="return-date"
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
                    id="return-time"
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