<style>
    .text-color-overall {
        color: #454545;
    }

    .join-us {
        text-align: center;
        /* padding-top: 70px; */
    }

    .why-join-us {
        font-size: 40px;
        font-weight: bold;
    }

    .join-us-reason {
        font-size: 25px;
        font-weight: 100
    }

    .for-center {
        justify-content: center;
        padding-top: 25px;
    }

    .more-reason-to {
        justify-content: center;
        padding-top: 40px;
    }

    .more-reason-text {
        font-size: 30px;
        font-weight: bold;
    }

    .FAQ-heading {
        font-size: 24px;
    }

    .FAQ-content {
        font-size: 17px;
    }

    .for-seller-stories {
        padding-top: 25px;
    }

    .seller-storeis-heading {
        place-content: center;
        padding-top: 30px;
    }

    .FAQ-content {
        margin: 10px 0px;
    }

    @media(max-width:768px) {
        .why-join-us {
            font-size: 25px;
        }

        .join-us-reason {
            font-size: 17px;
            padding: 0px 22px;
            text-align: justify;
        }

        .more-reason-text {
            font-size: 17px;
        }

        .FAQ-heading {
            font-size: 18px;
        }

        .nowrap-for-mobile-view {
            flex-wrap: nowrap !important;
        }

        #small_icons {
            width: 40px !important;
            margin-right: 12%;
            margin-top: 10%;
        }

        .levi-text {
            margin-top: 3%;
            font-size: 15px;
            font-weight: bold;
            word-spacing: 2px;
        }

        .levi-text1 {
            font-size: 13px;
            font-weight: 400;
            padding-left: 0px;
            padding-right: 0px;
            text-align: justify;
            word-spacing: 0px;
            line-height: 19px;
        }

        .not-complaint-yet {
            font-size: 20px;
            text-align: center;
            font-weight: bolder;
        }

        #img-for-mobile {
            max-width: 30%;
        }

        .padding-for-mobile {
            padding: 0px 9px;
        }
    }
</style>

<div id="wrapper" class="text-color-overall">
    <div class="row1">
        <div class="join-us ">
            <h2 class="why-join-us">Why You Should Join Us ?</h2>

            <h6 class="join-us-reason">Gharobaar is not only a marketplace; it's an attempt to connect your home to others
                and make you experience the warmth, love, care, tradition and uniqueness of each home. We aspire to promote
                business/individuals working from home to live their passion and fulfill their dreams. </h6>
        </div>
    </div>
    <div class="row1 for-center">

        <?php if ($this->auth_check) : ?>
            <center><a href="<?php echo generate_url("start_selling"); ?>" class="buttons-new">Register Now</a></center>
        <?php else : ?>
            <center><a href=" javascript:void(0)" data-toggle="modal" data-id="1" data-target="#registerModal" class="buttons-new open-via-sellnow">Register Now</a></center>

        <?php endif; ?>
    </div>
    <!-- <div class="col-md-5">
            <img id="ABOUT_LOGO" src="assets/img/image1.png" class="img-responsive image1">
        </div> -->
    <div class="row1 more-reason-to">
        <h3 class="more-reason-text">Some More Reasons To Join Our Family!</h3>
    </div>
    <div class="row1 nowrap-for-mobile-view">
        <div class="col-md-6 text-auto">
            <img id="small_icons" src="assets/img/house.png" class="img-responsive image1">
        </div>
        <div class="col-md-6 text-auto">
            <img id="small_icons" src="assets/img/leaf.png" class="img-responsive image1">
        </div>
    </div>
    <div class="row1 nowrap-for-mobile-view">
        <div class="col-md-6 text-auto">
            <h4 class="levi-text">
                Home-preneurs
            </h4>

            <h6 class="levi-text1">For partners operating from home, creating or trading in products (food and non-food) and
                offering exceptional services.</h6>
        </div>
        <div class="col-md-6 text-auto">
            <h4 class="levi-text">
                Organic
            </h4>

            <h6 class="levi-text1">Showcasing products created with love and care, in a hygenic setting with the comfort of
                home, and/or services enabling good life</h6>
        </div>
    </div>
    <div class="row1 nowrap-for-mobile-view">
        <div class="col-md-6 text-auto">
            <img id="small_icons" src="assets/img/smiling.png" class="img-responsive image1">
        </div>
        <div class="col-md-6 text-auto" style="margin-top:18px;">
            <img id="small_icons" src="assets/img/play.png" class="img-responsive image1">
        </div>
    </div>

    <div class="row1 nowrap-for-mobile-view">
        <div class="col-md-6 text-auto">
            <h4 class="levi-text">
                Connecting with emotions
            </h4>

            <h6 class="levi-text1">Promoting stories of our partner's grit, determination, commitment, passion and struggle,
                encouraging buyers to 'Go-Local' and 'Hoot-for our Roots.'</h6>
        </div>
        <div class="col-md-6 text-auto" style="margin-top:18px;">
            <h4 class="levi-text">
                Experience
            </h4>

            <h6 class="levi-text1">Not just a marketplace, but a feeling of working with friends and family. Seamless &
                transparent flow of information and transactions.</h6>
        </div>

    </div>


    <!-- <div class="row1">
        <div class="col-md-6 text-auto">
            <img id="small_icons" src="assets/img/smiling.png" class="img-responsive image1">
            
            <h4 class="levi-text">
                Connecting with emotion
            </h4>
            
            <h6 class="levi-text1">Promoting stories of our partner's grit. determination, commitment, passion and struggle,
                encouraging buyers to 'Go-Local' and 'Hoot-for ourRoots.'</h6>
        </div>
        <div class="col-md-6 text-auto">
            <img id="small_icons" src="assets/img/play.png" class="img-responsive image1">
            <h4 class="levi-text">
                Experience
            </h4>
            
            <h6 class="levi-text1">Not just a marketplace. but a feeling of working with friends and family. seamless &
                transparent flow of information and transaction</h6>
        </div>

    </div> -->
    <div class="row1 nowrap-for-mobile-view">
        <div class="col-md-6 text-auto">
            <img id="small_icons" src="assets/img/charts.png" class="img-responsive image1">
        </div>
        <div class="col-md-6 text-auto">
            <img id="small_icons" src="assets/img/chains.png" class="img-responsive image1">
        </div>
    </div>

    <div class="row1 text nowrap-for-mobile-view">
        <div class="col-md-6 text-auto">
            <h4 class="levi-text">
                Seller Promotion
            </h4>

            <h6 class="levi-text1">Curated promotions for sellers on social media, with seller videos, to showcase their stories with motivation for the business, current set up & process.</h6>
        </div>
        <div class="col-md-6 text-auto">
            <h4 class="levi-text">
                Integration & Flexible
            </h4>

            <h6 class="levi-text1">The platform would be integrated, enabling real-time updates, easy to use Interface, providing complete visibility of order lifecycle, along with the flexibilty for sellers to serve as per their capacity & convenience.</h6>
        </div>
    </div>


    <div class="row1 nowrap-for-mobile-view">
        <div class="col-md-6 text-auto">
            <img id="small_icons" src="assets/img/headphones.png" class="img-responsive image1">
        </div>
        <div class="col-md-6 text-auto">
            <img id="small_icons" src="assets/img/dart.png" class="img-responsive image1">
        </div>
    </div>

    <div class="row1 nowrap-for-mobile-view">
        <div class="col-md-6 text-auto">
            <h4 class="levi-text">
                Support In Business
            </h4>

            <h6 class="levi-text1">We have tied up with service providers to help you set up (GST registration, licenses), promote (content writing, photography, media management) and manage (delivery, packaging, accounting) your business.</h6>
        </div>
        <div class="col-md-6 text-auto">
            <h4 class="levi-text">
                Unique Positioning
            </h4>

            <h6 class="levi-text1">Suppliers categories(Phoenix, Out of Job, First venture, Sole bread earner, My passion my profession, Gritty over Sixty) designed to make buyers connect better. Loyalty/Performance-Linked rewards & recognition programs.</h6>
        </div>
    </div>

    <div class="row1">
        <div class="text-auto">
            <img id="small_icons" src="assets/img/barter.png" class="img-responsive image1" style="margin-top:30px">
            <h4 class="levi-text">
                Barter System
            </h4>

            <h6 class="levi-text1 padding-for-mobile">'Jadh se Judo' - Barter Karo Coordinate, collaborate, communicate, negotiate and facilitate trade with fellow sellers to exchange your products/services with their's.</h6>
        </div>
    </div>

    <div class="text-auto">

        <?php if ($this->auth_check) : ?>
            <center><a href="<?php echo generate_url("start_selling"); ?>" class="buttons-new">Register Now</a></center>
        <?php else : ?>
            <center><a href="javascript:void(0)" data-toggle="modal" data-id="1" data-target="#registerModal" class="buttons-new open-via-sellnow">Register Now</a></center>

        <?php endif; ?>
    </div>
    <div class="row1 text-auto" style="place-content: center;">
        <div class="text-auto">
            <h2 class="text-fam"> What's in it for you to join the family?</h2>
        </div>
    </div>




    <div class="row1 text-auto">
        <div class="text-centre">
            <img id="small_icons" src="assets/img/medal.png" class="img-responsive image1">

            <h3 class="levi-text"> Unique Loyalty/Performance program</h3>

            <h5 class="levi-text1 padding-for-mobile"> Comprehensive design with parameters focusing on sales, grow1th , exclusivity, alignment to platform theme and Gharobaar promotions. Interactive seller dashboards to help manage business better. Seamless movement to higher tiers with associated benefits of promotions, free/discounted services, etc.</h5>
        </div>
    </div>

    <div class="row1 text-auto nowrap-for-mobile-view">
        <div class="col-md-6">
            <img id="small_icons" src="assets/img/flexible.png" class="img-responsive image1">
        </div>
        <div class="col-md-6">
            <img id="small_icons" src="assets/img/reach.png" class="img-responsive image1">
        </div>
    </div>


    <div class="row1 text-auto nowrap-for-mobile-view">
        <div class="col-md-6">
            <h3 class="levi-text"> Flexi-Operations</h3>

            <h5 class="levi-text1"> Supplier to decide the radius for service, lead time to serve an order, days/time of operations (e.g only weekend working), accept or reject an order within 2 business hours, alerts & multiple communication channels (chat on the platform, mail, messages).</h5>
        </div>
        <div class="col-md-6">
            <h3 class="levi-text"> Wider Reach</h3>

            <h5 class="levi-text1"> Access to a community of buyers and sellers looking for homemade, high quality, daily need and lifestyle products & services that are easily available at reasonable prices. Almost everyone can be our buyer.</h5>
        </div>
    </div>




    <div class="row1 text-auto nowrap-for-mobile-view">
        <div class="col-md-6">
            <img id="small_icons" src="assets/img/heart.png" class="img-responsive image1">
        </div>
        <div class="col-md-6">
            <img id="small_icons" src="assets/img/card.png" class="img-responsive image1">
        </div>
    </div>


    <div class="row1 text-auto nowrap-for-mobile-view">
        <div class="col-md-6">
            <h3 class="levi-text"> Access to service providers</h3>

            <h5 class="levi-text1"> Highly rated service providers for marketing, packaging, delivery, and other services for managing operations @ low cost with prompt servicing promise.</h5>
        </div>
        <div class="col-md-6">
            <h3 class="levi-text"> Prompt Payment Processing</h3>

            <h5 class="levi-text1"> Multiple payment options- Payment gateways, credit cards, COD, Bank Transfers. Alerts on receipt of payment, weekly settlement.</h5>
        </div>
    </div>




    <div class="row1 text-auto">
        <div class="text-auto">
            <h2 class="text-punch">What is required from you to be a family member?</h2>
        </div>

    </div>

    <div class="row1 text-auto nowrap-for-mobile-view">
        <div class="col-md-6">
            <img id="small_icons" src="assets/img/proud.png" class="img-responsive image1">
            <h3 class="levi-text"> Proud of your offering</h3>

            <h5 class="levi-text1">We want partners who take pride in what they do, we want their energy and enthusiam to reflect in everything they do. Remind yourself of the reason why you started, where you are and what got you here.</h5>
        </div>
        <div class="col-md-6">
            <img id="small_icons" src="assets/img/board.png" class="img-responsive image1">

            <h3 class="levi-text"> Compliant with statutory requirements</h3>

            <h5 class="levi-text1"> You should have the business registered (preferably have GST & other statutory registrations, IPR/trademark), along with the relevant licenses & certifications (eg. FSSAI) for your products and services. Don't worry if you don't have these right now, we'll help you.</h5>
        </div>
    </div>
    <div class="row1 for-center">
        <h3 class="not-complaint-yet">Not compliant yet? No worries!
            We'll help you out!</h3>
    </div>
    <div class="row1 for-center">
        <?php if ($this->auth_check) : ?>
            <center><a href="<?php echo generate_url("contact"); ?>" class="buttons-help">Get help now!</a></center>
        <?php else : ?>
            <center><a href="<?php echo generate_url("contact"); ?>" class="buttons-help">Get help now!</a></center>

        <?php endif; ?>
    </div>

    <div class="row1 text-auto nowrap-for-mobile-view">
        <div class="col-md-6">
            <img id="small_icons" src="assets/img/serve-customers.png" class="img-responsive image1">

            <h3 class="levi-text"> Passion to serve Customers</h3>

            <h5 class="levi-text1">Exemplary customer service is at core of our operations, your decisions have to be driven by the intent to offer customers in each interaction, an experience that brings them back to Gharobaar.</h5>
        </div>
        <div class="col-md-6">
            <img id="small_icons" src="assets/img/quality.png" class="img-responsive image1">

            <h3 class="levi-text"> Quality conscious</h3>

            <h5 class="levi-text1"> 'Quality in everything we do' is a philosophy we strongly believe in, your products and services should be of the highest possible quality with no compromises.</h5>
        </div>
    </div>



    <div class="row1 text-auto nowrap-for-mobile-view">
        <div class="col-md-6">
            <img id="small_icons" src="assets/img/online-trading.png" class="img-responsive image1">
        </div>
        <div class="col-md-6">
            <img id="small_icons" src="assets/img/house2.png" class="img-responsive image1">
        </div>
    </div>

    <div class="row1 text-auto nowrap-for-mobile-view">
        <div class="col-md-6">
            <h3 class="levi-text"> Online Trading</h3>

            <h5 class="levi-text1"> You should be acquainted with how the online trading/bussiness works. Basic understanding is a must, and to manage any complexities of online trade, we would be at your service.</h5>
        </div>
        <div class="col-md-6">
            <h3 class="levi-text"> Home Operations </h3>

            <h5 class="levi-text1"> Your journey has started from home and you are not an established/big business. Our intent is to promote small businesses and partner with them in their grow1th journey over the years.</h5>

        </div>
    </div>
    <div class="row1 for-center">
        <?php if ($this->auth_check) : ?>
            <center><a href="<?php echo generate_url("start_selling"); ?>" class="buttons-new" style="padding-top=120px;">Register Now</a></center>
        <?php else : ?>
            <center><a href="javascript:void(0)" data-toggle="modal" data-id="1" data-target="#registerModal" class="buttons-new open-via-sellnow">Register Now</a></center>

        <?php endif; ?>

    </div>




    <div class="row1 seller-storeis-heading">
        <h2 class="not-complaint-yet">Seller Stories</h2>
    </div>


    <div class="row1 nowrap-for-mobile-view for-seller-stories">
        <div class="col-md-6" id="img-for-mobile">
            <div class="left-about-icons">
                <img id="seller-image" src="<?php echo base_url() . "uploads/profile/boy.jpg"; ?>" width="150" height="150">
                <div class="seller-name">Mr. Test Singh</div>
            </div>
        </div>
        <div class="col-md-6">
            <h5 class="levi-text1">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent volutpat dui felis, ut mattis urna interdum sed. Integer fringilla scelerisque sed.
            </h5>
        </div>
    </div>
    <!-- <div class="row1">
            <div class="col-12 col-sm-12 col-md-1"></div>
            <div class="col-12 col-sm-12 col-md-2">
                <div class="left-about-icons">
                    <img id="seller-image" src="<?php echo base_url() . "uploads/profile/girl.jpg"; ?>" width="150" height="150">
                    <div class="seller-name">Ms. Test Singh</div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-8">
                <div class="left-about-desc">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent volutpat dui
                    felis, u t mattis u rna interdum sed. I nteger fringilla scelerisque lacus sed
                    b ibendum. A enean ornare tortor eget ante scelerisque viverra. N ullam in est
                    mauris. N am ac mi ac felis aliquam fermentum. Morbi egestas lorem nec mauris
                    tincidunt, id scelerisque sem b ibendum. I nteger eu finibus enim. Fusce pulvinar
                    leo eros, vitae pulvinar mi consectetur sed.
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-1"></div>

        </div> -->
    <!-- <div class="row1">
            <div class="col-12 col-sm-12 col-md-1"></div>
            <div class="col-12 col-sm-12 col-md-2">
                <div class="left-about-icons">
                    <img id="seller-image" src="<?php echo base_url() . "uploads/profile/girl.jpg"; ?>" width="150" height="150">
                    <div class="seller-name">Ms. Test Singh</div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-8">
                <div class="left-about-desc">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent volutpat dui
                    felis, u t mattis u rna interdum sed. I nteger fringilla scelerisque lacus sed
                    b ibendum. A enean ornare tortor eget ante scelerisque viverra. N ullam in est
                    mauris. N am ac mi ac felis aliquam fermentum. Morbi egestas lorem nec mauris
                    tincidunt, id scelerisque sem b ibendum. I nteger eu finibus enim. Fusce pulvinar
                    leo eros, vitae pulvinar mi consectetur sed.
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-1"></div>

        </div> -->
    <!--<div class="row1 text-auto">-->



    <div class="text-auto" style="padding-top: 25px;">
        <div class="aura">

            <?php if ($this->auth_check) : ?>
                <center><a href="<?php echo generate_url("start_selling"); ?>" class="buttons-new ">See more seller stories!</a></center>
            <?php else : ?>
                <center><a href="javascript:void(0)" data-toggle="modal" data-id="1" data-target="#registerModal" class="buttons-new open-via-sellnow">See more seller stories!</a></center>

            <?php endif; ?>
        </div>

        <!-- <div class="row1-text-auto"> -->

    </div>


    <div class="row1 text-auto" style="padding-top: 25px;">
        <div class="col-md-12 text-centre">
            <h2 class="text-faq">F.A.Q's</h2>
            <ul style="list-style: none;text-align:justify; padding-left: 13px;">
                <b class="FAQ-heading">1. What do I need to register as a seller on Gharobaar?
                </b>
                <li class="FAQ-content">You will need to give us the following information:
                    Your business details (Company name, Brand
                    Name, Address, Product details)
                    Your contact details (Phone number, Email ID)
                    Tax Registration details (PAN and GST), Bank
                    Details, IPR/ Trademark
                    FSSAI License Details (for food products only)
                    \
                    Certification Details (for service providers)</li>


                <b class="FAQ-heading">2. I do not have a GST number, can I still sell on Gharobaar?
                </b>
                <li class="FAQ-content">No, as per guidelines, a GST number is mandatory for you to list any taxable product on an online platform</li>

                <b class="FAQ-heading">3. Am I liable to accept every return request placed by a buyer?
                </b>
                <li class="FAQ-content">We do not offer a no question asked return policy. We would look into every return request placed by a buyer, and evaluate it keeping everyone’s consideration in mind. Post the evaluation, the platform will take a call on the payment liability</li>

                <b class="FAQ-heading">4. How would my products be shipped?
                </b>
                <li class="FAQ-content">You do not need to worry about your product shipments. Just keep the products packed, and our delivery partner will pick them up from you and get them delivered</li>

                <b class="FAQ-heading">5. Would you be storing my products in your warehouse? </b>
                <li class="FAQ-content">
                    No, we do not have a warehouse. The products are picked from your home by our delivery partner and delivered directly to the buyer</li>

                <b class="FAQ-heading">6. Do I have to incur the shipping cost?</b>
                <li class="FAQ-content">
                    The shipping cost is auto-calculated at checkout, and has to be paid by the buyer. The buyer also has an option to take a subscription package from us and avail free deliveries</li>

                <b class="FAQ-heading">7. I am operating on a very small scale and
                    do not have a ready inventory of all my
                    products at all times. Would that be a
                    deal breaker?
                </b>
                <li class="FAQ-content">
                    At Gharobaar, we understand that when operating from home, you can only work at limited capacity. You do not need to have a ready inventory for any product that you list on our platform, and you can work entirely on pre-orders as well</li>

                <b class="FAQ-heading">8. Where can I see the orders placed?
                </b>
                <li class="FAQ-content">
                    You would be able to see all the orders placed on the platform, along with other details, on the seller dashboard page of the website. A separate app is also being developed for sellers where all the information from order to delivery, would be easily available.</li>

                <b class="FAQ-heading">9. Who can I reach out to in case I face a
                    problem?
                </b>
                <li class="FAQ-content">
                    Please reach us at sellerhelp@gharobaar.com. We will get in touch with you and assist you in resolving the problem</li>

                <b class="FAQ-heading">10. Do I need to enter into an agreement with Gharobaar before I can list my
                    products?
                </b>
                <li class="FAQ-content">
                    Yes, you would have to read and accept our Seller Agreement before onboarding on Gharobaar. The agreement would also be uploaded on our website/app, and can be accessed any time.
                </li>
            </ul>
        </div>

    </div>
    <div class="text-auto" style="padding-bottom: 40px;">
        <div class="aura">

            <?php if ($this->auth_check) : ?>
                <center><a href="<?php echo generate_url("start_selling"); ?>" class="buttons-new ">Register Now</a></center>
            <?php else : ?>
                <center><a href="javascript:void(0)" data-toggle="modal" data-id="1" data-target="#registerModal" class="buttons-new open-via-sellnow">Register Now</a></center>

            <?php endif; ?>
        </div>

        <!-- <div class="row1-text-auto"> -->

    </div>

</div>