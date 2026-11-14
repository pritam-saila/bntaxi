<style>
    .bn-footer-col a:hover{
        color: #fff;
    }
    
    
    /* =========================================================
   BN TAXI - POPULAR ROUTES SECTION
========================================================= */

.bn-routes-section {
    position: relative;
    overflow: hidden;

    padding: 90px 0 85px;

    background:
        linear-gradient(
            135deg,
            #071A4A 0%,
            #0B2D72 48%,
            #1647B8 100%
        );
}


/* =========================================
   BACKGROUND DECORATION
========================================= */

.bn-routes-section::before {
    content: "";

    position: absolute;

    left: 0;
    top: 0;

    width: 100%;
    height: 5px;

    background:
        linear-gradient(
            90deg,
            #2563EB 0%,
            #2563EB 35%,
            #3B82F6 35%,
            #3B82F6 65%,
            #2563EB 65%,
            #2563EB 100%
        );
}


.bn-routes-bg-shape {
    position: absolute;

    border-radius: 50%;

    pointer-events: none;
}


.bn-routes-shape-1 {
    width: 500px;
    height: 500px;

    right: -260px;
    top: -250px;

    border: 70px solid rgba(37, 99, 235, 0.06);
}


.bn-routes-shape-2 {
    width: 350px;
    height: 350px;

    left: -200px;
    bottom: -220px;

    border: 50px solid rgba(59, 130, 246, 0.07);
}


/* =========================================
   HEADING
========================================= */

.bn-routes-heading {
    position: relative;
    z-index: 2;

    max-width: 760px;

    margin: 0 auto 50px;

    text-align: center;
}


.bn-routes-eyebrow {
    display: inline-flex;

    align-items: center;
    gap: 8px;

    margin-bottom: 15px;

    padding: 8px 16px;

    border-radius: 50px;

    background: rgba(37, 99, 235, 0.12);

    border: 1px solid rgba(37, 99, 235, 0.28);

    color: #fff;

    font-size: 12px;

    font-weight: 800;

    letter-spacing: 1.7px;

    text-transform: uppercase;
}


.bn-routes-eyebrow i {
    font-size: 12px;
}


.bn-routes-heading h2 {
    margin: 0;

    color: #ffffff;

    font-size: clamp(34px, 4vw, 48px);

    line-height: 1.15;

    font-weight: 800;

    letter-spacing: -0.8px;
}


.bn-routes-heading h2 span {
    color: #2563EB;
}


.bn-routes-heading p {
    max-width: 600px;

    margin: 15px auto 0;

    color: rgba(255,255,255,0.72);

    font-size: 15px;

    line-height: 1.75;
}


/* =========================================
   ROUTE GRID
========================================= */

.bn-routes-grid {
    position: relative;
    z-index: 2;

    display: grid;

    grid-template-columns:
        repeat(3, minmax(0, 1fr));

    gap: 25px;
}


/* =========================================
   ROUTE CARD
========================================= */

.bn-route-card {
    position: relative;

    overflow: hidden;

    background: #ffffff;

    border-radius: 18px;

    border: 1px solid rgba(255,255,255,0.15);

    box-shadow:
        0 18px 45px rgba(0,0,0,0.18);

    transition:
        transform 0.35s ease,
        box-shadow 0.35s ease;
}


.bn-route-card:hover {
    transform: translateY(-7px);

    box-shadow:
        0 25px 55px rgba(0,0,0,0.25);
}


/* Yellow top line */

.bn-route-card::before {
    content: "";

    position: absolute;

    top: 0;
    left: 0;

    width: 100%;
    height: 4px;

    background:
        linear-gradient(
            90deg,
            #2563EB,
            #60A5FA
        );
}


/* =========================================
   CARD HEADER
========================================= */

.bn-route-card-top {
    display: flex;

    align-items: center;

    gap: 13px;

    padding: 21px 22px;

    background:
        linear-gradient(
            135deg,
            #f8fbfd,
            #eef5f8
        );

    border-bottom: 1px solid #e7edf1;
}


.bn-route-icon {
    width: 42px;
    height: 42px;

    flex: 0 0 42px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 12px;

    background:
        linear-gradient(
            135deg,
            #2563EB,
            #3B82F6
        );

    color: #123B8F;

    font-size: 17px;

    box-shadow:
        0 7px 17px rgba(37, 99, 235, 0.25);
}


.bn-route-card-label {
    color: #123B8F;

    font-size: 14px;

    font-weight: 800;

    letter-spacing: 0.5px;

    text-transform: uppercase;
}


/* =========================================
   ROUTE LIST
========================================= */

.bn-route-list {
    padding: 5px 20px 12px;
}


.bn-route-item {
    position: relative;

    display: flex;

    align-items: center;

    gap: 11px;

    min-height: 57px;

    padding: 10px 0;

    color: #25445f;

    text-decoration: none;

    border-bottom: 1px dashed #e2e8ed;

    transition:
        color 0.25s ease,
        padding-left 0.25s ease;
}


.bn-route-item:last-child {
    border-bottom: none;
}


.bn-route-item:hover {
    color: #1D4ED8;

    padding-left: 5px;
}


/* =========================================
   ARROW
========================================= */

.bn-route-arrow {
    width: 27px;
    height: 27px;

    flex: 0 0 27px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #EAF2FF;

    color: #1D4ED8;

    font-size: 10px;

    transition:
        background 0.25s ease,
        color 0.25s ease,
        transform 0.25s ease;
}


.bn-route-item:hover .bn-route-arrow {
    background: #2563EB;

    color: #123B8F;

    transform: translateX(3px);
}


/* =========================================
   ROUTE NAME
========================================= */

.bn-route-name {
    flex: 1;

    min-width: 0;

    font-size: 13px;

    font-weight: 500;

    line-height: 1.55;
}


/* =========================================
   RIGHT CHEVRON
========================================= */

.bn-route-link-icon {
    display: flex;

    align-items: center;
    justify-content: center;

    color: #b6c2cc;

    font-size: 9px;

    transition:
        color 0.25s ease,
        transform 0.25s ease;
}


.bn-route-item:hover .bn-route-link-icon {
    color: #2563EB;

    transform: translateX(3px);
}


/* =========================================
   BOTTOM CTA
========================================================= */

.bn-routes-cta {
    position: relative;
    z-index: 2;

    display: flex;

    align-items: center;

    gap: 18px;

    margin-top: 32px;

    padding: 22px 25px;

    border-radius: 16px;

    background:
        linear-gradient(
            100deg,
            rgba(37, 99, 235, 0.13),
            rgba(255,255,255,0.08)
        );

    border: 1px solid rgba(37, 99, 235, 0.25);

    backdrop-filter: blur(8px);
}


.bn-routes-cta-icon {
    width: 50px;
    height: 50px;

    flex: 0 0 50px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 14px;

    background: #2563EB;

    color: #123B8F;

    font-size: 19px;
}


.bn-routes-cta-content {
    display: flex;

    flex-direction: column;

    flex: 1;

    gap: 3px;
}


.bn-routes-cta-content strong {
    color: #ffffff;

    font-size: 15px;

    font-weight: 800;
}


.bn-routes-cta-content span {
    color: rgba(255,255,255,0.65);

    font-size: 13px;
}

.bn-routes-cta-icon i{
    color:#fff;
}
.bn-route-icon i{
    color:#fff;
}


.bn-routes-cta-btn {
    display: inline-flex;

    align-items: center;

    gap: 10px;

    padding: 12px 19px;

    border-radius: 9px;

    background: #2563EB;

    color: #fff;

    font-size: 13px;

    font-weight: 800;

    text-decoration: none;

    white-space: nowrap;

    transition:
        transform 0.25s ease,
        background 0.25s ease;
}


.bn-routes-cta-btn:hover {
    background: #ffffff;

    color: #123B8F;

    transform: translateY(-2px);
}


/* =========================================
   EMPTY STATE
========================================= */

.bn-routes-empty {
    position: relative;
    z-index: 2;

    max-width: 600px;

    margin: 0 auto;

    padding: 55px 25px;

    text-align: center;

    background: #ffffff;

    border-radius: 18px;

    box-shadow:
        0 20px 45px rgba(0,0,0,0.18);
}


.bn-routes-empty-icon {
    width: 70px;
    height: 70px;

    margin: 0 auto 18px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #EAF2FF;

    color: #1D4ED8;

    font-size: 28px;
}


.bn-routes-empty h3 {
    margin: 0 0 8px;

    color: #123B8F;

    font-size: 22px;
}


.bn-routes-empty p {
    margin: 0;

    color: #7c8995;

    font-size: 14px;
}


/* =========================================
   TABLET
========================================= */

@media (max-width: 991px) {

    .bn-routes-section {
        padding: 75px 0;
    }

    .bn-routes-grid {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 22px;
    }

    .bn-routes-heading {
        margin-bottom: 40px;
    }

    .bn-routes-cta {
        margin-top: 25px;
    }
}


/* =========================================
   MOBILE
========================================= */

@media (max-width: 767px) {

    .bn-routes-section {
        padding: 60px 0 65px;
    }

    .bn-routes-heading {
        margin-bottom: 30px;
    }

    .bn-routes-heading h2 {
        font-size: 34px;
    }

    .bn-routes-heading p {
        font-size: 14px;

        line-height: 1.7;
    }

    .bn-routes-grid {
        grid-template-columns: 1fr;

        gap: 18px;
    }

    .bn-route-card {
        border-radius: 15px;
    }

    .bn-route-card-top {
        padding: 18px 18px;
    }

    .bn-route-list {
        padding-left: 18px;
        padding-right: 18px;
    }

    .bn-route-item {
        min-height: 54px;
    }

    .bn-routes-cta {
        flex-wrap: wrap;

        padding: 20px;

        gap: 14px;
    }

    .bn-routes-cta-content {
        min-width: calc(100% - 70px);
    }

    .bn-routes-cta-btn {
        width: 100%;

        justify-content: center;

        margin-top: 3px;
    }
}


/* =========================================
   SMALL MOBILE
========================================= */

@media (max-width: 480px) {

    .bn-routes-section {
        padding: 50px 0 55px;
    }

    .bn-routes-eyebrow {
        font-size: 10px;

        padding: 7px 12px;
    }

    .bn-routes-heading h2 {
        font-size: 30px;
    }

    .bn-routes-heading p {
        font-size: 13px;
    }

    .bn-route-name {
        font-size: 12.5px;
    }

    .bn-route-card-top {
        padding: 17px;
    }

    .bn-route-list {
        padding: 3px 17px 10px;
    }

    .bn-route-arrow {
        width: 25px;
        height: 25px;

        flex-basis: 25px;
    }

    .bn-routes-cta-icon {
        width: 44px;
        height: 44px;

        flex-basis: 44px;
    }

    .bn-routes-cta-content strong {
        font-size: 14px;
    }

    .bn-routes-cta-content span {
        font-size: 12px;
    }
}

/* =========================================================
   BN TAXI - PREMIUM FOOTER
========================================================= */

.bn-footer {
    position: relative;
    overflow: hidden;

    background:
        linear-gradient(
            135deg,
            #061A45 0%,
            #0B2D72 48%,
            #1647B8 100%
        );

    color: #fff;
}


/* =========================================
   TOP ACCENT
========================================= */

.bn-footer-accent {
    width: 100%;
    height: 5px;

    background:
        linear-gradient(
            90deg,
            #2563EB 0%,
            #2563EB 32%,
            #2563EB 32%,
            #2563EB 68%,
            #2563EB 68%,
            #2563EB 100%
        );
}


/* =========================================
   BACKGROUND DECORATION
========================================= */

.bn-footer::before {
    content: "";

    position: absolute;

    width: 500px;
    height: 500px;

    right: -280px;
    top: -320px;

    border: 70px solid rgba(37, 99, 235, 0.045);

    border-radius: 50%;

    pointer-events: none;
}


.bn-footer::after {
    content: "";

    position: absolute;

    width: 350px;
    height: 350px;

    left: -230px;
    bottom: 80px;

    border: 55px solid rgba(59,130,246,0.055);

    border-radius: 50%;

    pointer-events: none;
}


/* =========================================
   MAIN GRID
========================================= */

.bn-footer-grid {
    position: relative;
    z-index: 2;

    display: grid;

    grid-template-columns:
        1.35fr
        0.8fr
        1fr
        1fr;

    gap: 55px;

    padding: 70px 0 55px;
}


/* =========================================
   BRAND
========================================= */

.bn-footer-brand {
    display: inline-flex;

    align-items: center;

    gap: 12px;

    margin-bottom: 22px;

    color: #fff;

    text-decoration: none;
}


.bn-brand-icon {
    width: 53px;
    height: 53px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 15px;

    background:
        linear-gradient(
            135deg,
            #2563EB,
            #3B82F6
        );

    color: #0A2A6B;

    font-size: 22px;

    box-shadow:
        0 10px 25px rgba(37, 99, 235, 0.20);
}


.bn-brand-text strong {
    display: block;

    color: #fff;

    font-size: 23px;

    line-height: 1;

    font-weight: 900;

    letter-spacing: 1px;
}


.bn-brand-text small {
    display: block;

    margin-top: 5px;

    color: #2563EB;

    font-size: 10px;

    font-weight: 800;

    letter-spacing: 3px;
}


/* =========================================
   ABOUT
========================================= */

.bn-footer-description {
    max-width: 350px;

    margin: 0 0 25px;

    color: rgba(255,255,255,0.68);

    font-size: 13px;

    line-height: 1.85;
}


/* =========================================
   CONTACT
========================================= */

.bn-contact {
    display: flex;

    flex-direction: column;

    gap: 12px;
}


.bn-contact a {
    display: flex;

    align-items: center;

    gap: 11px;

    color: rgba(255,255,255,0.88);

    font-size: 13px;

    font-weight: 600;

    text-decoration: none;

    transition: color .25s ease;
}


.bn-contact a:hover {
    color: #2563EB;
}


.bn-contact-icon {
    width: 35px;
    height: 35px;

    flex: 0 0 35px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 9px;

    background: rgba(37, 99, 235, 0.12);

    color: #fff;

    font-size: 12px;
}


.bn-contact small {
    display: block;

    margin-bottom: 2px;

    color: rgba(255,255,255,0.40);

    font-size: 9px;

    text-transform: uppercase;

    letter-spacing: .8px;
}


/* =========================================
   SOCIAL ICONS
========================================= */

.bn-footer-social {
    display: flex;

    gap: 9px;

    margin-top: 25px;
}


.bn-footer-social a {
    width: 36px;
    height: 36px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 9px;

    background: rgba(255,255,255,0.07);

    border: 1px solid rgba(255,255,255,0.09);

    color: rgba(255,255,255,0.75);

    text-decoration: none;

    font-size: 13px;

    transition: all .25s ease;
}


.bn-footer-social a:hover {
    background: #2563EB;

    border-color: #2563EB;

    color: #123B8F;

    transform: translateY(-3px);
}


/* =========================================
   COLUMN HEADINGS
========================================= */

.bn-footer-col h3 {
    display: flex;

    align-items: center;

    gap: 10px;

    margin: 4px 0 23px;

    color: #fff;

    font-size: 19px;

    font-weight: 750;
}


.bn-title-line {
    width: 4px;
    height: 21px;

    display: inline-block;

    border-radius: 5px;

    background: #2563EB;
}


/* =========================================
   LIST
========================================= */

.bn-footer-col ul {
    padding: 0;
    margin: 0;

    list-style: none;
}


.bn-footer-col ul li {
    margin-bottom: 12px;
}


.bn-footer-col ul li a {
    display: inline-flex;

    align-items: center;

    gap: 9px;

    color: rgba(255,255,255,0.67);

    font-size: 13px;

    text-decoration: none;

    transition:
        color .25s ease,
        transform .25s ease;
}


.bn-footer-col ul li a i {
    color: #2563EB;

    font-size: 9px;

    transition: transform .25s ease;
}


.bn-footer-col ul li a:hover {
    color: #fff;

    transform: translateX(5px);
}


.bn-footer-col ul li a:hover i {
    transform: translateX(3px);
}


.bn-no-service {
    color: rgba(255,255,255,0.4);

    font-size: 12px;
}


/* =========================================
   ADDRESS
========================================= */

.bn-address-card {
    display: flex;

    align-items: flex-start;

    gap: 13px;

    padding: 16px;

    margin-bottom: 17px;

    border-radius: 12px;

    background: rgba(255,255,255,0.055);

    border: 1px solid rgba(255,255,255,0.08);
}


.bn-address-icon {
    width: 39px;
    height: 39px;

    flex: 0 0 39px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background: rgba(37, 99, 235, 0.13);

    color: #2563EB;

    font-size: 14px;
}


.bn-address-card small {
    display: block;

    margin-bottom: 5px;

    color: rgba(255,255,255,0.4);

    font-size: 9px;

    font-weight: 600;

    text-transform: uppercase;

    letter-spacing: .8px;
}


.bn-address-card p {
    margin: 0;

    color: rgba(255,255,255,0.78);

    font-size: 12.5px;

    line-height: 1.7;
}


/* =========================================
   AVAILABILITY
========================================= */

.bn-availability {
    display: flex;

    align-items: center;

    gap: 10px;

    margin-bottom: 17px;
}


.bn-online-dot {
    width: 10px;
    height: 10px;

    flex: 0 0 10px;

    border-radius: 50%;

    background: #22c55e;

    box-shadow:
        0 0 0 5px rgba(34,197,94,0.10);
}


.bn-availability strong {
    display: block;

    color: #fff;

    font-size: 12px;
}


.bn-availability small {
    display: block;

    margin-top: 2px;

    color: rgba(255,255,255,0.4);

    font-size: 10px;
}


/* =========================================
   BOOK BUTTON
========================================= */

.bn-btn {
    display: flex;

    align-items: center;

    justify-content: center;

    gap: 10px;

    width: 100%;

    padding: 13px 17px;

    border-radius: 10px;

    background:
        linear-gradient(
            135deg,
            #2563EB,
            #3B82F6
        );

    color: #fff !important;

    font-size: 13px;

    font-weight: 800;

    text-decoration: none !important;

    box-shadow:
        0 10px 25px rgba(37, 99, 235, 0.17);

    transition:
        transform .25s ease,
        box-shadow .25s ease;
}


.bn-btn > span {
    width: 25px;
    height: 25px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 6px;

    background: rgba(0,0,0,0.10);
}


.bn-btn-arrow {
    margin-left: auto;

    font-size: 10px;
}


.bn-btn:hover {
    color: #0A2A6B !important;

    transform: translateY(-3px);

    box-shadow:
        0 15px 30px rgba(37, 99, 235, 0.25);
}


/* =========================================
   POPULAR SERVICES BAR
========================================= */

.bn-footer-service-bar {
    position: relative;
    z-index: 2;

    display: flex;

    align-items: center;

    gap: 25px;

    padding: 19px 0;

    border-top: 1px solid rgba(255,255,255,0.08);

    border-bottom: 1px solid rgba(255,255,255,0.08);
}


.bn-service-bar-title {
    display: flex;

    align-items: center;

    gap: 9px;

    color: #fff;

    font-size: 11px;

    font-weight: 800;

    letter-spacing: .6px;

    text-transform: uppercase;

    white-space: nowrap;
}


.bn-service-bar-links {
    display: flex;

    align-items: center;

    flex-wrap: wrap;

    gap: 7px 20px;
}


.bn-service-bar-links a {
    color: rgba(255,255,255,0.52);

    font-size: 11px;

    text-decoration: none;

    transition: color .25s ease;
}


.bn-service-bar-links a:hover {
    color: #2563EB;
}


/* =========================================
   BOTTOM
========================================= */

.bn-footer-bottom {
    position: relative;
    z-index: 2;

    background: rgba(2,11,22,0.50);
}


.bn-footer-bottom-inner {
    min-height: 70px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;
}


.bn-footer-bottom p {
    margin: 0;

    color: rgba(255,255,255,0.43);

    font-size: 11.5px;
}


.bn-footer-bottom p strong {
    color: rgba(255,255,255,0.75);
}


.bn-social {
    display: flex;

    align-items: center;

    gap: 14px;
}


.bn-social a {
    color: rgba(255,255,255,0.58);

    font-size: 11.5px;

    text-decoration: none;

    transition: color .25s ease;
}


.bn-social a:hover {
    color: #2563EB;
}


.bn-social span {
    width: 1px;
    height: 13px;

    background: rgba(255,255,255,0.20);
}


/* =========================================
   TABLET
========================================= */

@media (max-width: 991px) {

    .bn-footer-grid {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 42px 35px;

        padding: 60px 0 45px;
    }


    .bn-footer-about {
        grid-column: span 2;
    }


    .bn-footer-description {
        max-width: 650px;
    }


    .bn-footer-service-bar {
        flex-direction: column;

        align-items: flex-start;

        gap: 13px;
    }

}


/* =========================================
   MOBILE
========================================= */

@media (max-width: 767px) {

    .bn-footer-grid {
        grid-template-columns: 1fr;

        gap: 32px;

        padding: 48px 0 40px;
    }


    .bn-footer-about {
        grid-column: auto;
    }


    .bn-footer-description {
        max-width: 100%;

        font-size: 13px;

        line-height: 1.75;
    }


    .bn-footer-col h3 {
        margin-bottom: 18px;

        font-size: 18px;
    }


    .bn-footer-col ul li {
        margin-bottom: 10px;
    }


    .bn-footer-service-bar {
        padding: 17px 0;
    }


    .bn-service-bar-links {
        gap: 8px 14px;
    }


    .bn-footer-bottom-inner {
        min-height: auto;

        flex-direction: column;

        align-items: flex-start;

        gap: 12px;

        padding: 20px 0;
    }


    .bn-social {
        gap: 10px;

        flex-wrap: wrap;
    }

}


/* =========================================
   SMALL MOBILE
========================================= */

@media (max-width: 480px) {

    .bn-footer-grid {
        gap: 28px;

        padding-top: 42px;
    }


    .bn-brand-icon {
        width: 48px;
        height: 48px;

        font-size: 20px;
    }


    .bn-brand-text strong {
        font-size: 21px;
    }


    .bn-footer-description {
        font-size: 12.5px;
    }


    .bn-contact a {
        font-size: 12px;
    }


    .bn-footer-col ul li a {
        font-size: 12px;
    }


    .bn-service-bar-links a {
        font-size: 10.5px;
    }


    .bn-footer-bottom p {
        font-size: 10.5px;
    }


    .bn-social a {
        font-size: 10.5px;
    }

}
</style>


<!-- =========================================
     BN TAXI - POPULAR ROUTES
========================================= -->

<section class="bn-routes-section">

    <div class="bn-routes-bg-shape bn-routes-shape-1"></div>
    <div class="bn-routes-bg-shape bn-routes-shape-2"></div>

    <div class="container">

        <!-- Heading -->
        <div class="bn-routes-heading">

            <span class="bn-routes-eyebrow">
                <i class="fas fa-route"></i>
                BN TAXI SERVICES
            </span>

            <h2>
                Popular <span>Taxi Routes</span>
            </h2>

            <p>
                Explore our most popular taxi routes across Brighton,
                Sussex and surrounding areas.
            </p>

        </div>


        @php
            $routehandles = App\Models\Routehandle::all();

            /*
             * Divide routes into 3 balanced columns.
             * This is better than split(3), which can create
             * uneven columns when the route count changes.
             */
            $routeCount = $routehandles->count();

            $perColumn = $routeCount > 0
                ? (int) ceil($routeCount / 3)
                : 1;

            $routeChunks = $routehandles->chunk($perColumn);
        @endphp


        @if($routeCount > 0)

            <div class="bn-routes-grid">

                @foreach($routeChunks as $chunk)

                    <div class="bn-route-card">

                        <div class="bn-route-card-top">

                            <div class="bn-route-icon">
                                <i class="fas fa-taxi"></i>
                            </div>

                            <span class="bn-route-card-label">
                                Taxi Routes
                            </span>

                        </div>


                        <div class="bn-route-list">

                            @foreach($chunk as $route)

                                <a
                                    href="{{ url('/route-details/'.$route->slug) }}"
                                    class="bn-route-item"
                                >

                                    <span class="bn-route-arrow">
                                        <i class="fas fa-arrow-right"></i>
                                    </span>

                                    <span class="bn-route-name">
                                        {{ $route->title }}
                                    </span>

                                    <span class="bn-route-link-icon">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>

                                </a>

                            @endforeach

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="bn-routes-empty">

                <div class="bn-routes-empty-icon">
                    <i class="fas fa-route"></i>
                </div>

                <h3>No Taxi Routes Available</h3>

                <p>
                    Popular taxi routes will appear here soon.
                </p>

            </div>

        @endif


        <!-- Bottom CTA -->
        <div class="bn-routes-cta">

            <div class="bn-routes-cta-icon">
                <i class="fas fa-car"></i>
            </div>

            <div class="bn-routes-cta-content">
                <strong>Need a taxi somewhere else?</strong>
                <span>
                    Get in touch with BN Taxi Anytime for your journey.
                </span>
            </div>

            <a href="{{ url('/book-now') }}" class="bn-routes-cta-btn">
                Book a Taxi
                <i class="fas fa-arrow-right"></i>
            </a>

        </div>

    </div>

</section>

<footer class="bn-footer">

    <!-- TOP ACCENT -->
    <div class="bn-footer-accent"></div>

    <div class="container">

        <div class="bn-footer-grid">

            <!-- =====================================
                 LOGO + ABOUT
            ====================================== -->
            <div class="bn-footer-col bn-footer-about">

                <a href="{{ url('') }}" class="bn-footer-brand">

                    <span class="bn-brand-icon">
                        <i class="fa fa-taxi"></i>
                    </span>

                    <span class="bn-brand-text">
                        <strong>BN TAXI</strong>
                        <small>ANYTIME</small>
                    </span>

                </a>


                <p class="bn-footer-description">
                    BN Taxi Anytime provides safe, reliable and affordable
                    taxi service across Brighton and surrounding areas.
                    Available 24/7 for your convenience.
                </p>


                <!-- CONTACT -->
                <div class="bn-contact">

                    <a href="tel:+441273757373">

                        <span class="bn-contact-icon">
                            <i class="fa fa-phone"></i>
                        </span>

                        <span>
                            <small>Call Us 24/7</small>
                            01273 757373
                        </span>

                    </a>


                    <a href="mailto:info@bntaxianytime.com">

                        <span class="bn-contact-icon">
                            <i class="fa fa-envelope"></i>
                        </span>

                        <span>
                            <small>Email Us</small>
                            info@bntaxianytime.com
                        </span>

                    </a>

                </div>


                <!-- SOCIAL -->
                <div class="bn-footer-social">

                    {{-- Only profiles with a real URL are shown (set them in .env, see config/services.php). --}}
                    @php $biz = config('services.business'); @endphp
                    @foreach ([
                        ['facebook_url', 'Facebook', 'fab fa-facebook'],
                        ['instagram_url', 'Instagram', 'fab fa-instagram'],
                        ['twitter_url', 'X (Twitter)', 'fab fa-twitter'],
                        ['whatsapp_url', 'WhatsApp', 'fab fa-whatsapp'],
                    ] as [$key, $label, $icon])
                        @if (!empty($biz[$key]))
                            <a href="{{ $biz[$key] }}" target="_blank" rel="noopener" aria-label="BN Taxi Anytime on {{ $label }}">
                                <i class="{{ $icon }}" aria-hidden="true"></i>
                            </a>
                        @endif
                    @endforeach

                </div>

            </div>


            <!-- =====================================
                 QUICK LINKS
            ====================================== -->
            <div class="bn-footer-col">

                <h3>
                    <span class="bn-title-line"></span>
                    Quick Links
                </h3>

                <ul>

                    <li>
                        <a href="{{ url('') }}">
                            <i class="fa fa-angle-right"></i>
                            Home
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('about') }}">
                            <i class="fa fa-angle-right"></i>
                            About Us
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('faq') }}">
                            <i class="fa fa-angle-right"></i>
                            FAQs
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('news') }}">
                            <i class="fa fa-angle-right"></i>
                            Blog
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('contact') }}">
                            <i class="fa fa-angle-right"></i>
                            Contact Us
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('book-now') }}">
                            <i class="fa fa-angle-right"></i>
                            Book Now
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('gallery') }}">
                            <i class="fa fa-angle-right"></i>
                            Gallery
                        </a>
                    </li>

                </ul>

            </div>


            <!-- =====================================
                 SERVICES
            ====================================== -->
            <div class="bn-footer-col">

                <h3>
                    <span class="bn-title-line"></span>
                    Our Services
                </h3>

                <ul>

                    @php
                        $routehandles = App\Models\Service::all();
                    @endphp

                    @if(isset($routehandles) && count($routehandles) > 0)

                        @foreach($routehandles as $route)

                            <li>
                                <a href="{{ url('/route-details/'.$route->slug) }}">
                                    <i class="fa fa-angle-right"></i>
                                    {{ $route->title }}
                                </a>
                            </li>

                        @endforeach

                    @else

                        <li>
                            <span class="bn-no-service">
                                No services available
                            </span>
                        </li>

                    @endif

                </ul>

            </div>


            <!-- =====================================
                 ADDRESS + BOOKING
            ====================================== -->
            <div class="bn-footer-col bn-footer-location">

                <h3>
                    <span class="bn-title-line"></span>
                    Find Us
                </h3>


                <!-- ADDRESS CARD -->
                <div class="bn-address-card">

                    <div class="bn-address-icon">
                        <i class="fa fa-map-marker"></i>
                    </div>

                    <div>

                        <small>Our Location</small>

                        <p>
                            @if (config('services.business.street_address'))
                                {{ config('services.business.street_address') }},<br>
                            @else
                                Saunders Park,<br>
                            @endif
                            Brighton {{ config('services.business.postcode') }},<br>
                            United Kingdom
                        </p>

                    </div>

                </div>


                <!-- AVAILABLE -->
                <div class="bn-availability">

                    <span class="bn-online-dot"></span>

                    <div>
                        <strong>Available 24/7</strong>
                        <small>Ready when you are</small>
                    </div>

                </div>


                <!-- BOOK BUTTON -->
                <a
                    href="{{ url('book-now') }}"
                    class="bn-btn"
                >

                    <span>
                        <i class="fa fa-taxi"></i>
                    </span>

                    Book Your Taxi

                    <i class="fa fa-arrow-right bn-btn-arrow"></i>

                </a>

            </div>

        </div>


        <!-- =====================================
             SERVICE QUICK BAR
        ====================================== -->
        <div class="bn-footer-service-bar">

            <div class="bn-service-bar-title">

                <i class="fa fa-road"></i>

                <span>Popular Taxi Services</span>

            </div>


            <div class="bn-service-bar-links">

                <a href="{{ url('book-now') }}">
                    Brighton Taxi
                </a>

                <a href="{{ url('book-now') }}">
                    Airport Transfers
                </a>

                <a href="{{ url('book-now') }}">
                    Heathrow Taxi
                </a>

                <a href="{{ url('book-now') }}">
                    Gatwick Taxi
                </a>

                <a href="{{ url('book-now') }}">
                    Corporate Taxi
                </a>

            </div>

        </div>

    </div>


    <!-- =====================================
         COPYRIGHT
    ====================================== -->
    <div class="bn-footer-bottom">

        <div class="container">

            <div class="bn-footer-bottom-inner">

                <p>
                    &copy; {{ date('Y') }}
                    <strong>BN Taxi Anytime</strong>.
                    All Rights Reserved.
                </p>


                <div class="bn-social">

                    <a href="{{ url('privacy-policy') }}">
                        Privacy Policy
                    </a>

                    <span></span>

                    <a href="{{ url('terms-and-conditions') }}">
                        Terms and Conditions
                    </a>

                </div>

            </div>

        </div>

    </div>

</footer>

<div class="overlay" id="overlay" onclick="closeNav()"></div>


<style>
/* =========================================================
   BN TAXI - PREMIUM MOBILE SIDEBAR
   Heavy Royal Blue + White Theme
   Existing dynamic markup/JS preserved
   ========================================================= */

.sidenav {
    position: fixed !important;
    top: 0 !important;
    right: auto !important;
    left: 0 !important;

    width: 360px !important;
    max-width: 88vw !important;
    height: 100vh !important;

    padding: 0 !important;
    margin: 0 !important;

    background:
        linear-gradient(
            155deg,
            #061d4f 0%,
            #0b3d9e 48%,
            #1557d6 100%
        ) !important;

    color: #fff !important;

    box-shadow:
        18px 0 50px rgba(0, 20, 65, .30) !important;

    overflow-x: hidden !important;
    overflow-y: auto !important;

    z-index: 99999 !important;

    scrollbar-width: thin;
    scrollbar-color: rgba(255,255,255,.25) transparent;
}

/* Decorative circles */
.sidenav::before {
    content: "";
    position: absolute;

    width: 300px;
    height: 300px;

    right: -190px;
    top: -120px;

    border: 55px solid rgba(255,255,255,.055);
    border-radius: 50%;

    pointer-events: none;
}

.sidenav::after {
    content: "";
    position: absolute;

    width: 230px;
    height: 230px;

    left: -155px;
    bottom: 30px;

    border: 42px solid rgba(255,255,255,.045);
    border-radius: 50%;

    pointer-events: none;
}


/* =========================================================
   TOP PROFILE AREA
   ========================================================= */

.sidenav .menu-top {
    position: relative;
    z-index: 2;

    display: flex !important;
    align-items: center !important;

    min-height: 105px !important;

    padding: 20px 18px 18px !important;

    background:
        linear-gradient(
            135deg,
            rgba(255,255,255,.10),
            rgba(255,255,255,.035)
        ) !important;

    border-bottom:
        1px solid rgba(255,255,255,.12) !important;

    box-shadow:
        0 8px 24px rgba(0,0,0,.10);
}


/* Close button */
.sidenav .close-btn {
    position: absolute !important;

    top: 17px !important;
    right: 17px !important;

    width: 38px !important;
    height: 38px !important;

    display: flex !important;
    align-items: center !important;
    justify-content: center !important;

    margin: 0 !important;

    border-radius: 11px !important;

    background: rgba(255,255,255,.12) !important;

    border:
        1px solid rgba(255,255,255,.16) !important;

    color: #fff !important;

    font-size: 14px !important;

    cursor: pointer !important;

    transition:
        background .22s ease,
        transform .22s ease;
}

.sidenav .close-btn:hover {
    background: #fff !important;
    color: #0b3d9e !important;
    transform: rotate(90deg);
}


/* Profile */
.sidenav .profile {
    display: flex !important;
    align-items: center !important;

    width: 100% !important;

    padding-right: 48px !important;

    box-sizing: border-box !important;
}

.sidenav .profile-text {
    min-width: 0;
}

.sidenav .profile-text h3 {
    margin: 0 0 5px !important;

    color: #fff !important;

    font-size: 24px !important;
    line-height: 1.1 !important;

    font-weight: 900 !important;

    letter-spacing: .4px !important;
}

.sidenav .profile-text p {
    margin: 0 !important;

    color: rgba(255,255,255,.65) !important;

    font-size: 11px !important;
    line-height: 1.4 !important;

    font-weight: 600 !important;
}


/* =========================================================
   MENU AREA
   ========================================================= */

.sidenav .menu-links {
    position: relative;
    z-index: 2;

    padding: 20px 15px 25px !important;
}

.sidenav .menu-links > ul {
    margin: 0 !important;
    padding: 0 !important;

    list-style: none !important;
}


/* All main links */
.sidenav .menu-links > ul > a,
.sidenav .menu-links > ul > li > .nav-link,
.sidenav .menu-links > ul > li > a:not(.dropdown-item) {
    position: relative !important;

    display: flex !important;
    align-items: center !important;

    width: 100% !important;
    min-height: 50px !important;

    box-sizing: border-box !important;

    margin: 4px 0 !important;
    padding: 11px 14px !important;

    border-radius: 11px !important;

    background: rgba(255,255,255,.045) !important;

    border:
        1px solid rgba(255,255,255,.06) !important;

    color: rgba(255,255,255,.90) !important;

    font-size: 13px !important;

    font-weight: 700 !important;

    line-height: 1.2 !important;

    text-decoration: none !important;

    transition:
        background .22s ease,
        color .22s ease,
        transform .22s ease,
        border-color .22s ease;
}


/* Arrow icons */
.sidenav .menu-links > ul > a > i,
.sidenav .menu-links > ul > li > .nav-link > i,
.sidenav .menu-links > ul > li > a:not(.dropdown-item) > i {
    width: 31px !important;
    height: 31px !important;

    flex: 0 0 31px !important;

    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;

    margin-right: 11px !important;

    border-radius: 8px !important;

    background: rgba(255,255,255,.10) !important;

    color: #fff !important;

    font-size: 10px !important;

    transition:
        background .22s ease,
        color .22s ease;
}


/* Hover */
.sidenav .menu-links > ul > a:hover,
.sidenav .menu-links > ul > li > .nav-link:hover,
.sidenav .menu-links > ul > li > a:not(.dropdown-item):hover {
    background: #fff !important;

    border-color: #fff !important;

    color: #0b3d9e !important;

    transform: translateX(4px);
}

.sidenav .menu-links > ul > a:hover > i,
.sidenav .menu-links > ul > li > .nav-link:hover > i,
.sidenav .menu-links > ul > li > a:not(.dropdown-item):hover > i {
    background: #eaf3ff !important;
    color: #1557d6 !important;
}


/* =========================================================
   DROPDOWN
   ========================================================= */

.sidenav .menu-links .dropdown {
    position: relative;
}

.sidenav .menu-links .dropdown-menu {
    position: static !important;

    width: 100% !important;

    box-sizing: border-box !important;

    margin: 3px 0 7px !important;

    padding: 6px !important;

    border-radius: 12px !important;

    background:
        rgba(2, 25, 72, .82) !important;

    border:
        1px solid rgba(255,255,255,.12) !important;

    box-shadow:
        inset 0 1px 0 rgba(255,255,255,.05),
        0 10px 25px rgba(0,0,0,.12) !important;

    backdrop-filter: blur(8px);
}


/* Dropdown items */
.sidenav .menu-links .dropdown-menu .dropdown-item {
    display: flex !important;
    align-items: center !important;

    min-height: 42px !important;

    margin: 2px 0 !important;

    padding: 9px 11px !important;

    box-sizing: border-box !important;

    border-radius: 8px !important;

    background: transparent !important;

    color: rgba(255,255,255,.78) !important;

    font-size: 12px !important;

    font-weight: 600 !important;

    text-decoration: none !important;

    transition:
        background .2s ease,
        color .2s ease,
        padding-left .2s ease;
}

.sidenav .menu-links .dropdown-menu .dropdown-item:hover {
    background: rgba(255,255,255,.12) !important;

    color: #fff !important;

    padding-left: 15px !important;
}


/* Login dropdown icons */
.sidenav .menu-links .dropdown-menu .dropdown-item i {
    width: 25px !important;
    color: #8fc1ff !important;
}


/* =========================================================
   MY ACCOUNT
   ========================================================= */

.sidenav .menu-links > ul > li.menubg {
    margin-top: 9px !important;
}

.sidenav .menu-links > ul > li.menubg > a {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;

    min-height: 50px !important;

    border-radius: 11px !important;

    background:
        linear-gradient(
            135deg,
            #ffffff,
            #edf5ff
        ) !important;

    color: #0b3d9e !important;

    font-size: 13px !important;

    font-weight: 850 !important;

    text-decoration: none !important;

    box-shadow:
        0 10px 24px rgba(0,0,0,.14) !important;
}


/* =========================================================
   SEPARATOR / LOWER AREA
   ========================================================= */

.sidenav .menu-links::after {
    content: "BN TAXI ANYTIME  •  AVAILABLE 24/7";

    display: block;

    margin: 20px 5px 0;
    padding: 13px 10px;

    text-align: center;

    border-top:
        1px solid rgba(255,255,255,.10);

    color:
        rgba(255,255,255,.48);

    font-size: 8px;

    font-weight: 800;

    letter-spacing: 1px;
}


/* =========================================================
   OVERLAY
   ========================================================= */

.overlay {
    position: fixed !important;

    inset: 0 !important;

    z-index: 99998 !important;

    background:
        rgba(2,12,32,.58) !important;

    backdrop-filter:
        blur(3px);

    -webkit-backdrop-filter:
        blur(3px);
}


/* =========================================================
   SCROLLBAR
   ========================================================= */

.sidenav::-webkit-scrollbar {
    width: 5px;
}

.sidenav::-webkit-scrollbar-track {
    background: transparent;
}

.sidenav::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,.22);
    border-radius: 20px;
}

.sidenav::-webkit-scrollbar-thumb:hover {
    background: rgba(255,255,255,.38);
}


/* =========================================================
   MOBILE
   ========================================================= */

@media (max-width: 480px) {

    .sidenav {
        width: 330px !important;
        max-width: 90vw !important;
    }

    .sidenav .menu-top {
        min-height: 94px !important;
        padding: 17px 14px !important;
    }

    .sidenav .profile-text h3 {
        font-size: 21px !important;
    }

    .sidenav .menu-links {
        padding:
            15px 12px 22px !important;
    }

    .sidenav .menu-links > ul > a,
    .sidenav .menu-links > ul > li > .nav-link,
    .sidenav .menu-links > ul > li > a:not(.dropdown-item) {
        min-height: 47px !important;

        margin: 3px 0 !important;

        padding: 9px 11px !important;

        font-size: 12px !important;
    }

    .sidenav .menu-links > ul > a > i,
    .sidenav .menu-links > ul > li > .nav-link > i,
    .sidenav .menu-links > ul > li > a:not(.dropdown-item) > i {
        width: 29px !important;
        height: 29px !important;
        flex-basis: 29px !important;

        margin-right: 9px !important;
    }

    .sidenav .close-btn {
        width: 35px !important;
        height: 35px !important;

        top: 14px !important;
        right: 14px !important;
    }
}
</style>


<style>
/* =========================================================
   BN TAXI - SIDEBAR OPEN/CLOSE STATE
   Explicit state so Close always works
   ========================================================= */

.sidenav {
    transform: translateX(-105%) !important;
    visibility: hidden !important;
    opacity: 0 !important;

    transition:
        transform .32s cubic-bezier(.4,0,.2,1),
        opacity .25s ease,
        visibility 0s linear .32s !important;
}

.sidenav.bn-sidebar-open {
    transform: translateX(0) !important;
    visibility: visible !important;
    opacity: 1 !important;

    transition:
        transform .32s cubic-bezier(.4,0,.2,1),
        opacity .25s ease,
        visibility 0s linear 0s !important;
}

.overlay {
    visibility: hidden !important;
    opacity: 0 !important;

    transition:
        opacity .25s ease,
        visibility 0s linear .25s !important;
}

.overlay.bn-overlay-open {
    visibility: visible !important;
    opacity: 1 !important;
}

body.bn-sidebar-active {
    overflow: hidden !important;
}
</style>

<!-- SIDENAV -->

<div id="mySidenav" class="sidenav">

    <div class="menu-top">

        <div class="close-btn" onclick="closeNav()">
            <i class="fa fa-times"></i>
        </div>

        <div class="profile">
            <!--<img src="https://i.pravatar.cc/150?img=12">-->

            <div class="profile-text">
                <h3>BN Taxi</h3>
                @auth
                <p>Welcome back ðŸ‘‹</p>
                @endauth
            </div>
        </div>

    </div>

    <div class="menu-links">

        <ul class="">

                        <a href="{{url('')}}"><i class="fa fa-arrow-right" aria-hidden="true"></i> Home</a>
                        <a href="{{url('about')}}"><i class="fa fa-arrow-right" aria-hidden="true"></i> About Us</a>

                        <!-- Services Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="fa fa-arrow-right" aria-hidden="true"></i> Services
                            </a>

                            <ul class="dropdown-menu shadow border-0">
                                @php
                                    $services = App\Models\Service::all();
                                @endphp

                                @if(isset($services) && count($services) > 0)
                                    @foreach($services as $service)
                                        <li>
                                            <a class="dropdown-item" href="{{url('/service-details/'.$service->slug)}}">
                                                {{$service->title}}
                                            </a>
                                        </li>
                                    @endforeach
                                @else
                                    <li>
                                        <a class="dropdown-item text-muted" href="#">
                                            No Services Available
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>

                        <a href="{{url('faq')}}"><i class="fa fa-arrow-right" aria-hidden="true"></i> Faqs</a>
                        <a href="{{url('news')}}"><i class="fa fa-arrow-right" aria-hidden="true"></i> Blog</a>
                        <a href="{{url('contact')}}"><i class="fa fa-arrow-right" aria-hidden="true"></i> Contact Us</a>
                        <a href="{{url('book-now')}}"><i class="fa fa-arrow-right" aria-hidden="true"></i> Book Now</a>
                        <a href="{{url('gallery')}}"><i class="fa fa-arrow-right" aria-hidden="true"></i> Gallery</a>

                        <!-- Login Dropdown -->
                        @if(!auth()->user())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="fa fa-arrow-right" aria-hidden="true"></i> Login
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                <li>
                                    <a class="dropdown-item" href="{{url('/user-login')}}">
                                        <i class="fa fa-user me-2"></i> Customer Login
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{url('/driver-login')}}">
                                        <i class="fa fa-car me-2"></i> Driver Login
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @else
                            <li class="menubg">
                                <a href="{{url('/user-account')}}">My Account</a>
                            </li>
                        @endif

                    </ul>

    </div>

    <!--<div class="social-area">-->

    <!--    <div class="social-title">-->
    <!--        FOLLOW US-->
    <!--    </div>-->

    <!--    <div class="social-icons">-->

    <!--        <a href="#" class="fb">-->
    <!--            <i class="fab fa-facebook-f"></i>-->
    <!--        </a>-->

    <!--        <a href="#" class="insta">-->
    <!--            <i class="fab fa-instagram"></i>-->
    <!--        </a>-->

    <!--        <a href="#" class="yt">-->
    <!--            <i class="fab fa-youtube"></i>-->
    <!--        </a>-->

    <!--        <a href="#" class="whatsapp">-->
    <!--            <i class="fab fa-whatsapp"></i>-->
    <!--        </a>-->

    <!--    </div>-->

    <!--</div>-->

</div>



<script>

document.querySelectorAll('.dropdown-toggle').forEach(function(btn){

    btn.addEventListener('click', function(e){

        e.preventDefault();

        let menu = this.parentElement.querySelector('.dropdown-menu');

        if(menu.style.display === "block"){

            menu.style.display = "none";

        }else{

            menu.style.display = "block";

        }

    });

});

</script>


<script>
/* =========================================================
   BN TAXI - ROBUST SIDEBAR CONTROLS
   ========================================================= */

(function () {

    function getSidebar() {
        return document.getElementById("mySidenav");
    }

    function getOverlay() {
        return document.getElementById("overlay");
    }

    function openSidebar() {
        var sidebar = getSidebar();
        var overlay = getOverlay();

        if (sidebar) {
            sidebar.classList.add("bn-sidebar-open");
        }

        if (overlay) {
            overlay.classList.add("bn-overlay-open");
        }

        document.body.classList.add("bn-sidebar-active");
    }

    function closeSidebar() {
        var sidebar = getSidebar();
        var overlay = getOverlay();

        if (sidebar) {
            sidebar.classList.remove("bn-sidebar-open");
        }

        if (overlay) {
            overlay.classList.remove("bn-overlay-open");
        }

        document.body.classList.remove("bn-sidebar-active");
    }

    /* Make these available to the existing inline onclick attributes. */
    window.openNav = openSidebar;
    window.closeNav = closeSidebar;

    function bindSidebarEvents() {

        var closeBtn = document.querySelector(
            "#mySidenav .close-btn"
        );

        var overlay = document.getElementById("overlay");

        if (closeBtn) {
            closeBtn.onclick = function (e) {
                e.preventDefault();
                e.stopPropagation();
                closeSidebar();
                return false;
            };
        }

        if (overlay) {
            overlay.onclick = function (e) {
                e.preventDefault();
                closeSidebar();
                return false;
            };
        }

        /* Support common mobile menu buttons without changing markup. */
        var menuButtons = document.querySelectorAll(
            ".bn-mobile-menu-btn, .mobile-menu-btn, .menu-toggle, [data-menu-toggle]"
        );

        menuButtons.forEach(function (btn) {
            btn.addEventListener("click", function (e) {
                e.preventDefault();
                openSidebar();
            });
        });
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", bindSidebarEvents);
    } else {
        bindSidebarEvents();
    }

    /* ESC closes the sidebar */
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") {
            closeSidebar();
        }
    });

})();
</script>

<div class="whatsapp-position">
  <a id="wpClick" href="https://wa.me/447491757373" target="_blank" rel="noopener" aria-label="Chat with BN Taxi on WhatsApp"><i class="fab fa-whatsapp" aria-hidden="true"></i></a>
</div>