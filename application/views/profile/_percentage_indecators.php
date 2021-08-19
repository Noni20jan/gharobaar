<style>
    .flex-wrapper {
        display: flex;
        flex-flow: row nowrap;
        margin: 30px 0;
    }

    .single-chart {
        width: 100%;
        justify-content: space-around;
        margin-bottom: 40px;
    }

    .circular-chart {
        display: block;
        margin: 10px auto;
        max-width: 50%;
        max-height: 250px;
    }

    .circle-bg {
        fill: none;
        stroke: #eee;
        stroke-width: 3.8;
    }

    .circle {
        fill: none;
        stroke-width: 2.8;
        stroke-linecap: round;
        animation: progress 1s ease-out forwards;
    }

    @keyframes progress {
        0% {
            stroke-dasharray: 0 100;
        }
    }

    .circular-chart.orange .circle {
        stroke: #ff9f00;
    }

    .circular-chart.green .circle {
        stroke: #4CC790;
    }

    .circular-chart.blue .circle {
        stroke: #3c9ee5;
    }

    .percentage {
        fill: #666;
        font-family: sans-serif;
        font-size: 0.5em;
        text-anchor: middle;
    }

    .percent-heading {
        text-align: center;
        font-size: 24px;
        /*18px for mobile*/
        font-weight: 600;
    }

    .percent-subheading {
        text-align: center;
        font-size: 14px;
    }

    .percentage-desc {
        padding: 0 15px;
    }

    #more,
    #more1,
    #more2 {
        display: none;
    }
</style>
<div class="row">
    <div class="col-12 col-sm-12 col-md-4">
        <div class="single-chart">
            <svg viewBox="0 0 36 36" class="circular-chart orange">
                <path class="circle-bg" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831" />
                <path class="circle" stroke-dasharray="30, 100" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831" />
                <text x="18" y="20.35" class="percentage">30%</text>
            </svg>
            <div class="percentage-desc">
                <div class="percent-heading">Customer Engagement Index</div>
                <div class="percent-subheading">
                    <p style="text-align: justify;">Number of products/services ordered by customer - 50% weightage
                        Number of page views - 10% weightage
                        Time spent on supplier page – 10% weightage
                        Repeat orders placed by customers – 30%
                        </span></p>
                    <a class="more-link" href="javascript:void()" onclick="myFunction2()" id="myBtn2">Read more</a>
                </div>

                <script>
                    function myFunction2() {
                        var dots = document.getElementById("dots2");
                        var moreText = document.getElementById("more2");
                        var btnText = document.getElementById("myBtn2");

                        if (dots.style.display === "none") {
                            dots.style.display = "inline";
                            btnText.innerHTML = "Read more";
                            moreText.style.display = "none";
                        } else {
                            dots.style.display = "none";
                            btnText.innerHTML = "Read less";
                            moreText.style.display = "inline";
                        }
                    }
                </script>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-12 col-md-4">
        <div class="single-chart">
            <svg viewBox="0 0 36 36" class="circular-chart green">
                <path class="circle-bg" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831" />
                <path class="circle" stroke-dasharray="60, 100" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831" />
                <text x="18" y="20.35" class="percentage">60%</text>
            </svg>
            <div class="percentage-desc">
                <div class="percent-heading">Rating & Comments Score</div>
                <div class="percent-subheading">
                    <p style="text-align: justify;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus imperdiet, nulla et dictum interdum, nisi lorem egestas vitae scel<span id="dots1">...</span><span id="more1">erisque enim ligula venenatis dolor. Maecenas nisl est, ultrices nec congue eget, auctor vitae massa. Fusce luctus vestibulum augue ut aliquet. Nunc sagittis dictum nisi, sed ullamcorper ipsum dignissim ac. In at libero sed nunc venenatis imperdiet sed ornare turpis. Donec vitae dui eget tellus gravida venenatis. Integer fringilla congue eros non fermentum. Sed dapibus pulvinar nibh tempor porta.</span></p>
                    <a class="more-link" href="javascript:void()" onclick="myFunction1()" id="myBtn1">Read more</a>
                </div>

                <script>
                    function myFunction1() {
                        var dots = document.getElementById("dots1");
                        var moreText = document.getElementById("more1");
                        var btnText = document.getElementById("myBtn1");

                        if (dots.style.display === "none") {
                            dots.style.display = "inline";
                            btnText.innerHTML = "Read more";
                            moreText.style.display = "none";
                        } else {
                            dots.style.display = "none";
                            btnText.innerHTML = "Read less";
                            moreText.style.display = "inline";
                        }
                    }
                </script>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-12 col-md-4">
        <div class="single-chart">
            <svg viewBox="0 0 36 36" class="circular-chart blue">
                <path class="circle-bg" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831" />
                <path class="circle" stroke-dasharray="90, 100" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831" />
                <text x="18" y="20.35" class="percentage">90%</text>
            </svg>
            <div class="percentage-desc">
                <div class="percent-heading">Growth Journey</div>
                <div class="percent-subheading">
                    <p style="text-align: justify;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus imperdiet, nulla et dictum interdum, nisi lorem egestas vitae scel<span id="dots">...</span><span id="more">erisque enim ligula venenatis dolor. Maecenas nisl est, ultrices nec congue eget, auctor vitae massa. Fusce luctus vestibulum augue ut aliquet. Nunc sagittis dictum nisi, sed ullamcorper ipsum dignissim ac. In at libero sed nunc venenatis imperdiet sed ornare turpis. Donec vitae dui eget tellus gravida venenatis. Integer fringilla congue eros non fermentum. Sed dapibus pulvinar nibh tempor porta.</span></p>
                    <a class="more-link" href="javascript:void()" onclick="myFunction()" id="myBtn">Read more</a>
                </div>

                <script>
                    function myFunction() {
                        var dots = document.getElementById("dots");
                        var moreText = document.getElementById("more");
                        var btnText = document.getElementById("myBtn");

                        if (dots.style.display === "none") {
                            dots.style.display = "inline";
                            btnText.innerHTML = "Read more";
                            moreText.style.display = "none";
                        } else {
                            dots.style.display = "none";
                            btnText.innerHTML = "Read less";
                            moreText.style.display = "inline";
                        }
                    }
                </script>
            </div>
        </div>
    </div>





</div>