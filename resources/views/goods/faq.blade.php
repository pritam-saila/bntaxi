<!doctype html>
<html>
    <head>
        
          <meta charset="UTF-8">
          <title>BN Taxi Anytime | Brighton Taxi & Airport Transfers </title>
  <meta name="description" content="Reliable Brighton taxi service, available 24/7. Airport transfers, wedding cars & corporate travel with fixed prices. Book your ride online now. ">
  <meta name="keywords" content="Brighton taxi">
  
  <meta name="viewport" content="width=device-width, initial-scale=1.0">


        @include('goods.include.assets')
    </head>
    <body>
        @include('goods.include.header')

        <!-- ================= BANNER ================= -->
        <section class="banner">
            <div class="container banner-content">
                <h1>FAQs</h1>
                <p>Reliable & Professional Brighton Taxi Service</p>
            </div>
        </section>

        <section class="faq-section">
            <div class="faq-title">
                <h2>Frequently Asked Questions</h2>
                <p>Everything you need to know about our taxi services</p>
            </div>

            <!-- FAQ Item -->
            <div class="faq-item">
                <div class="faq-question">
                    Q: What areas do you cover?
                    <div class="faq-icon">+</div>
                </div>
                <div class="faq-answer">
                    <p>We cover Brighton and Hove, and the surrounding areas.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    Q: Are your prices per car or per person?
                    <div class="faq-icon">+</div>
                </div>
                <div class="faq-answer">
                    <p>We charge per car, the number of passengers does not change the price.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    Q: How much luggage can I take?
                    <div class="faq-icon">+</div>
                </div>
                <div class="faq-answer">
                    <p>Up to a total of 4 pieces of luggage : 2 big suitcases and 2 small suitcases.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    Q: How do I know my booking has been accepted?
                    <div class="faq-icon">+</div>
                </div>
                <div class="faq-answer">
                    <p>
                        After we receive your booking request, our team will reach out to you in order to verify the
                        details and to arrange the payment
                    </p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    Q: What if I cannot locate my driver?
                    <div class="faq-icon">+</div>
                </div>
                <div class="faq-answer">
                    <p>
                        As soon as you land you will receive a greeting text from the driver. If you have any
                        difficulties locating your driver, please call the number that texted you.
                    </p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    Q: What if I wish to cancel and want a refund?
                    <div class="faq-icon">+</div>
                </div>
                <div class="faq-answer">
                    <p>
                        To receive a refund you need to give a 48 hours notice to cancel your booking. The funds should
                        be returned to your account within 7-14 days. Please note that transaction fees will apply.
                    </p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    Q: Will I be charged extra if my flight is delayed?
                    <div class="faq-icon">+</div>
                </div>
                <div class="faq-answer">
                    <p>
                        We will only charge you after 1 hour of after your flight has landed. If your flight is delayed
                        please notify us so we can make relevant change. We will also continue to track your flight via
                        the airport website for uptodate times.
                    </p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    Q: What if I miss my flight?
                    <div class="faq-icon">+</div>
                </div>
                <div class="faq-answer">
                    <p>You will be charged the normal fee for our services. The 48 hours notice applies here also.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    Q: How early do I need to book?
                    <div class="faq-icon">+</div>
                </div>
                <div class="faq-answer">
                    <p>
                        You can try to book anytime, but to avoid disappointment, we suggest you complete your booking
                        at least 24 hours in advance.
                    </p>
                </div>
            </div>
        </section>

        @include('goods.include.footer')

        <script>
            document.querySelectorAll(".faq-question").forEach((item) => {
                item.addEventListener("click", () => {
                    const parent = item.parentElement;

                    document.querySelectorAll(".faq-item").forEach((el) => {
                        if (el !== parent) {
                            el.classList.remove("active");
                        }
                    });

                    parent.classList.toggle("active");
                });
            });
        </script>
    </body>
</html>
