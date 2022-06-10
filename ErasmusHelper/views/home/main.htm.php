<?php

use ErasmusHelper\Controllers\Router;

?>
<div id="homepage" class="container-fluid px-xl-5" xmlns:mailto="http://www.w3.org/1999/xhtml">
    <div class="row pt-xl-0 pt-3 justify-content-center">
        <div class="col-auto text-center">
            <h4 class="fancy-font">About SumsEra</h4>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="d-none d-xl-flex mx-auto">
            <img src="<?= Router::resource("images", "sumsera1.png") ?>" class="rounded-img" alt="">
        </div>
        <div class="d-xl-none col text-center">
            <img src="<?= Router::resource("images", "sumsera1.png") ?>" class="rounded-img" alt="">
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="d-none d-xl-flex c col-xl-7 text-center">
            <h2 class="fancy-font">To help integration and to provide a stress-free experience for ERASMUS
                students.</h2>
        </div>
        <div class="d-xl-none col text-center">
            <h3 class="fancy-font">To help integration and to provide a stress-free experience for ERASMUS
                students.</h3>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col col-xl-7 text-center">
            <h5 class="mb-3">A company born at FEUP.</h5>
            <h5>A success story idealized in the LGP challenge</h5>
        </div>
    </div>
    <div class="row justify-content-center">
        <a class="btn btn-xl" href="mailto:sumsera.lgp@gmail.com"><i class="fa fa-envelope" aria-hidden="true"></i>
        </a>
        <a class="btn btn-xl" href="https://www.instagram.com/sumsera.lgp/"><i class="fa fa-instagram"
                                                                               aria-hidden="true"></i></a>
    </div>
    <div id="row-with-video" class="d-none d-xl-flex row mt-5 px-xl-5">
        <div class="col background-white ultra-small-rounded py-5">
            <div class="row h-100">
                <div class="col-6 border-divisor-right">
                    <h3 class="fancy-font mb-4">About Us</h3>
                    <p>A group of 10 students from LGP Course</p>
                </div>
                <div class="col-6">
                    <iframe width="100%" height="100%" src="https://www.youtube.com/embed/PRACK9_A5AE?autoplay=1&mute=1"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    ></iframe>
                </div>
            </div>
        </div>
    </div>
    <div id="row-with-video" class="d-xl-none row mt-5">
        <div class="col background-white ultra-small-rounded py-5">
            <div class="row h-50 border-divisor-bottom">
                <div class="col">
                    <h3 class="fancy-font mb-4">About Us</h3>
                    <p>A group of 10 students from LGP Course</p>
                </div>
            </div>
            <div class="row h-50">
                <div class="col">
                    <iframe width="100%" height="100%" src="https://www.youtube.com/embed/PRACK9_A5AE?autoplay=1&mute=1"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5 mb-3">
        <h3>Erasmus in Figures</h3>
    </div>
    <div class="row px-xl-5 justify-content-around">
        <div class="col-8 col-xl-2 mr-xl-3 mb-3 text-center homepage-figure background-white small-rounded">
            <h3 class="py-3 fancy-font">34</h3>
            <p>Countries members inside and outside European Union</p>
        </div>
        <div class="col-8 col-xl-2 mb-3 text-center homepage-figure background-white small-rounded">
            <h3 class="py-3 fancy-font">4M</h3>
            <p>The number of Students that benefited from Erasmus Program </p>
        </div>
        <div class="col-8 col-xl-2 mb-3 text-center homepage-figure background-white small-rounded">
            <h3 class="py-3 fancy-font">+300K</h3>
            <p>The number of Students that sign for Erasmus yearly </p>
        </div>
        <div class="col-8 col-xl-2 mb-3 text-center homepage-figure background-white small-rounded">
            <h3 class="py-3 fancy-font">31K</h3>
            <p>Spain is the #1 country for Erasmus. It receives 31 thousand students yearly</p>
        </div>
    </div>
    <div id="row-with-video" class="d-none d-xl-flex row mt-5 px-xl-5">
        <div class="col background-white ultra-small-rounded py-5">
            <div class="row h-100">
                <div class="col-6 border-divisor-right">
                    <h3 class="fancy-font mb-4">What is Erasmus Helper</h3>
                    <p>The product we present you is Erasmus Helper</p>
                </div>
                <div class="col-6 text-center">
                    <img id="qr-big" src="<?= Router::resource("images", "qr.png") ?>" class="pt-5" alt="">
                    <!--
                    <iframe width="100%" height="100%" src="https://www.youtube.com/embed/1FJHYqE0RDg?autoplay=0&mute=1"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
                    -->
                </div>
            </div>
        </div>
    </div>
    <div id="row-with-video" class="d-xl-none row mt-5">
        <div class="col background-white ultra-small-rounded py-5">
            <div class="row h-50 border-divisor-bottom">
                <div class="col">
                    <h3 class="fancy-font mb-4">What is Erasmus Helper</h3>
                    <p>The product we present you is Erasmus Helper</p>
                </div>
            </div>
            <div class="row h-50">
                <div class="col text-center">
                    <img id="qr-small" src="<?= Router::resource("images", "qr.png") ?>" alt="">
                    <!--
                        <iframe width="100%" height="100%" src="https://www.youtube.com/embed/1FJHYqE0RDg?autoplay=0&mute=1"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
                    -->
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5 mb-3">
        <h3>LGP in Figures</h3>
    </div>
    <div class="row px-xl-5 justify-content-around">
        <div class="col-8 col-xl-2 mb-3 mr-xl-3 text-center homepage-figure background-white small-rounded">
            <h3 class="py-3 fancy-font">23</h3>
            <p>Years of Experience</p>
        </div>
        <div class="col-8 col-xl-2 mb-3 text-center homepage-figure background-white small-rounded">
            <h3 class="py-3 fancy-font">4</h3>
            <p>Courses of University Involved: MEIC, MM, MESG, MESW </p>
        </div>
        <div class="col-8 col-xl-2 mb-3 text-center homepage-figure background-white small-rounded">
            <h3 class="py-3 fancy-font">20 + 4</h3>
            <p>20 Teams and 4 agencies in the 2022 edition. 250 Students</p>
        </div>
        <div class="col-8 col-xl-2 mb-3 text-center homepage-figure background-white small-rounded">
            <h3 class="py-3 fancy-font">+2500</h3>
            <p>The number of Students that experienced the LGP challenge </p>
        </div>
    </div>
    <div id="row-with-video" class="d-none d-xl-flex row mt-5 px-xl-5">
        <div class="col background-white ultra-small-rounded py-5">
            <div class="row h-100">
                <div class="col-6 border-divisor-right">
                    <h3 class="fancy-font mb-4">FEUP & LGP</h3>
                    <p></p>
                </div>
                <div class="col-6">
                    <iframe width="100%" height="100%" src="https://www.youtube.com/embed/akObFAN9sgw?autoplay=0&mute=1"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    ></iframe>
                </div>
            </div>
        </div>
    </div>
    <div id="row-with-video" class="d-xl-none row mt-5">
        <div class="col background-white ultra-small-rounded py-5">
            <div class="row border-divisor-bottom h-50">
                <div class="col">
                    <h3 class="fancy-font mb-4">FEUP & LGP</h3>
                    <p></p>
                </div>
            </div>
            <div class="row h-50">
                <iframe width="100%" height="100%" src="https://www.youtube.com/embed/akObFAN9sgw?autoplay=0&mute=1"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                ></iframe>
            </div>
        </div>
    </div>

</div>