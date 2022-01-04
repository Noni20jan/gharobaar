<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    .new-about-us {
        place-content: center;
        box-shadow: 2px 2px 5px #808080de;
        background-color: white;
        border-radius: 15px;
        padding: 0 15px;
    }

    /* .ghr-se-ghr-tk {
        width: 61%;
        padding: 20px 0px;
    } */

    .aboutus-content {
        max-width: 100%;
        background: #fff;
        box-shadow: 2px 2px 5px #808080de;
        padding: 20px;
        border-radius: 22px;
        margin-top: 30px;
    }

    #over-lapped {
        max-width: 73%;
        margin-left: 13%;
        border-radius: 22px;
        margin-top: -12%;
        box-shadow: 2px 2px 5px #808080de;
        padding: 2%
    }

    .aboutus-journey {
        line-height: 35px;
        text-align: justify;
    }

    #as-on-figma {
        font-weight: 700;
        font-size: 20px;
        width: 15%;
    }

    .rowbutton {
        padding: 5% 0;
        text-align: center;
    }

    /* .our-background {
        border-radius: 30px;
        padding: 12px 12px;
        width: 83%;
        box-shadow: 0px 8px 20px 4px rgb(0 0 0 / 25%);
    } */

    .our-story-content {
        line-height: 32px;
        background: #fff;
        box-shadow: 2px 2px 5px #808080de;
        border-radius: 13px;
        width: 100%;
        text-align: center;
        padding: 20px 15px;
    }

    .font-personal-use {
        font-family: adelline personal use only;
        font-style: normal;
        font-weight: normal;
        font-size: 100px;
        line-height: 96px;
        align-items: center;
        text-align: center;
        color: #A4785C;
    }

    .founders {
        font-weight: 500;
        /* line-height: 1.2; */
        font-family: "Montserrat", sans-serif;
        margin-bottom: 50px;

    }

    .row-founding-members {
        text-align: center;
        margin-top: 7%;
    }

    #sakshi-md-6 {
        left: 7%;
        max-width: 23%;
        z-index: 3;
    }

    #aditya-md-6 {
        left: 4%;
        max-width: 30%;
    }


    .founders-content2 {
        left: 9%;
    }

    .for-sakshi {
        margin-left: 10%;
        text-align: justify;
    }

    .for-aditya {
        margin-right: 7%;
        text-align: justify;
    }

    #vision-md-6 {
        margin-top: -16%;
        max-width: 96%;
    }


    /* .flower-pot {
        margin-left: 8%;
        width: 50%;
    }

    .jadh-se-judo {
        margin-left: 6%;
        width: 50%;
        margin-top: 15%;
    } */

    .vission-text {
        text-align: center;
    }

    #pprod-issue {
        left: 5%;
    }

    .mission-mission {
        text-align: center;
    }

    #for-mobile-and-web {
        max-width: 100%;
        margin-top: 11%;
    }

    #for-mobile-and-web-2 {
        max-width: 100%;
    }

    @media(max-width:786px) {
        #vision-md-6 {
            margin-top: 4%;
            max-width: 96%;
        }

        .for-sakshi {
            text-align: center;
            margin-left: 0%;
        }

        .for-aditya {
            text-align: center;
            margin-right: 0%;

        }

        #for-mobile-and-web {
            max-width: 100%;
            text-align: center;
            margin-top: 11%;
        }

        #for-mobile-and-web-2 {
            max-width: 100%;
            text-align: center;
        }

        @media(max-width:700px) {
            .col-6 {
                -ms-flex: 0 0 100%;
                flex: 0 0 100%;
                max-width: 100%
            }
        }

        #pprod-issue {
            left: 1% !important;
        }

        .founders-content2 {
            left: 0px !important;
        }

        #ghrtk {
            width: 100%;
            background-color: white;
            border-radius: 35px;
            box-shadow: 2px 2px 5px #808080de;
            margin-left: 1%;
        }

        .aboutus-content {
            max-width: 100%;
            background: #fff;
            box-shadow: 2px 2px 5px #808080de;
            padding: 20px;
            border-radius: 22px;
            margin-top: 30px;
        }

        #as-on-figma {
            font-weight: 700;
            font-size: 20px;
            width: 55%;
            box-shadow: 2px 2px 5px #808080de;
        }

        #sakshi-md-6 {
            left: 18%;
            max-width: 66%;
            z-index: 3;
        }

        #aditya-md-6 {
            left: 13%;
            max-width: 30%;
            margin-top: 5%;
        }

        .aboutus-journey {
            line-height: 30px;
        }

        .our-story-content {
            line-height: 26px !important;
            background: #fff;
            box-shadow: 2px 2px 5px #808080de;
            border-radius: 13px;
            width: 100%;
            text-align: initial !important;
            padding: 20px 15px;
        }
    }
</style>



<div id="wrapper" class="index-wrapper">
    <div class="container">
        <!-- <div class="row new-about-us">
            <img class="ghr-se-ghr-tk" src="assets/img/aboutus-logo.png">
        </div> -->
        <div class="row" style="place-content:center; padding:0 15px;">
            <div class="aboutus-content col-md-8">
                <h4 style="text-align: center;">About Us</h4>
                <p class="aboutus-journey">The journey of Gharobaar started over a get together post Diwali. We were discussing life during pandemic, pursuance of hobbies and discovering our hidden talents. From cooking variety of cuisines to creating innovative craft for our kidsbirthdays, we were excited about our creations and joked about approaching an e-commerce platform to showcase our products. Over the next couple of weeks we came across many inspirational stories of homepreneurs (businesses run from home), how they've not been bogged down by the adversity and instead created opportunities of becoming self reliant. These homepreneurs chose to follow their passion, demonstrate their grit, rise from the ashes, and earn bread for their families with their heads held high. We decided to become part of these exceptional journeys, by creating a platform to facilitate their reach to a wider buyer community. Gharobaar is not only a marketplace; it's an attempt to connect your home to others' and make you experience the warmth, love, care, tradition and uniqueness of each home. </p>
            </div>
        </div>
        <!-- <div class="rowbutton">
            <a href="<? //php echo generate_url("why_sell_with_us"); 
                        ?>" class="btn btn-md btn-custom btn-sell-now m-r-0" id="as-on-figma"><//?= trans("sell_now"); ?></a>
        </div> -->
        <!-- <div class="row" id="for-mobile-and-web">
        <div class="col-md-6" id="pprod-issue">
            <h3 class="mission-mission">OUR MISSION</h3>

            <p class="our-story-content">Create evergrowing family of buyers and sellers, transacting in quality products & services, provided from home at affordable prices, and offering exceptional services to all the family members.</p>

        </div>
        <div class="col-md-6">
            <img class="flower-pot" src="assets/img/flower-pot.png">
        </div>
    </div> -->
        <!-- <div class="row" id="for-mobile-and-web-2">
        <div class="col-md-6" style="margin-top: -10%;">
            <img src="assets/img/“Jadh se judo”.png" class="jadh-se-judo">
        </div>
        <div class="col-md-6" id="vision-md-6">
            <h3 class="vission-text">OUR VISION</h3>

            <p class="our-story-content">Be India's most preferred marketplace, known for contributing effectively to the society, facilitating the entrepreneurial journey of aspiring local talent, and staying connected to our roots.</p>

        </div>
    </div> -->
        <div class="row" style="margin-top:5%;">
            <div class="col-6">
                <h3 class="mission-mission">Our Mission</h3>
                <p class="our-story-content">Create evergrowing family of buyers and sellers, transacting in quality products & services, provided from home at affordable prices, and offering exceptional services to all the family members.</p>
            </div>
            <div class="col-6">
                <h3 class="vission-text">Our Vision</h3>
                <p class="our-story-content">Be India's most preferred marketplace, known for contributing effectively to the society, facilitating the entrepreneurial journey of aspiring local talent, and staying connected to our roots.</p>
            </div>
        </div>
        <div class="row-founding-members">
            <h2 class="founders">Meet The Founding Family Members</h2>
        </div>
        <div class="row">
            <div class="col-md-4" id="sakshi-md-6">
                <img src="assets/img/sakshi.png" style="width:100%;">
            </div>
            <div class="col-md-8 founders-content1">
                <div class="our-story-content" style="text-align:center !important;">
                    <h2>Sakshi Aggarwal</h2>
                    <h6>Serial E-commerce Buyer</h6>
                    <p class="for-sakshi">Wealth manager for 9 years, a homemaker for 4 years, raising two beautiful daughters. Necessity pushed her into
                        online buying, now is addicted to it, spends average 5 hours
                        a day exploring the world-wide-web and promoting
                        businesses as a buyer. Her smile is infectious.</p>
                </div>
            </div>

        </div>
        <div class="row" style="margin-top: 10%;">
            <div class="col-md-8 founders-content2">
                <div class="our-story-content" style="text-align:center !important;">
                    <h2>Aditya Gupta</h2>
                    <h6>Experienced E-commerce Seller</h6>
                    <p class="for-aditya">Entrepreneur with a legacy of selling spices in Asia's largest
                        wholesale hub. He dared to move out of the established
                        brick & mortar business and created a niche brand of nuts,
                        berries & spices, being sold on all online platforms. He’s
                        also an aspiring cricketer for the last 25 years.</p>
                </div>
            </div>
            <div class="col-md-4" id="aditya-md-6">
                <img src="assets/img/aditya.png">
            </div>
        </div>
        <!-- <div class="rowbutton">
            <a href="<//?php echo generate_url("why_sell_with_us"); ?>" class="btn btn-md btn-custom btn-sell-now m-r-0" id="as-on-figma"><//?= trans("sell_now"); ?></a>
        </div> -->
    </div>
</div>