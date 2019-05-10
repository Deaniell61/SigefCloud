<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
        crossorigin="anonymous"></script>

<div id="gifts">
    <img id="gift" src="images/giftbox.jpg">
</div>

<div hidden id="wallLogin">
    <div id="container">
        <div id="dialog">
            <p id="text">Please login to continue</p>
            <div class="fb-login-button" data-max-rows="1" data-size="large" data-button-type="continue_with"
                 data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="true"
                 data-onlogin="postLogin()" data-scope="email,user_likes"></div>
        </div>
    </div>
</div>

<div hidden id="wall">
    <div id="container">
        <div id="dialog">
            <p id="text">Please help us with a like in our fan page!</p>
            <div class="fb-page" data-href="https://www.facebook.com/ShopGuateDirect/" data-small-header="true"
                 data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false">
                <blockquote cite="https://www.facebook.com/ShopGuateDirect/" class="fb-xfbml-parse-ignore"><a
                            href="https://www.facebook.com/ShopGuateDirect/">Guate Direct</a></blockquote>
            </div>
            <br>
            <br>
            <img id="close" src="images/close.png">
        </div>
    </div>
</div>

<script>
    var lostFocus = 0;
    var loggedIn = false;
    window.fbAsyncInit = function () {
        FB.init({
            appId: '238076850099684',
            autoLogAppEvents: true,
            xfbml: true,
            version: 'v3.1'
        });

        FB.getLoginStatus(function (response) {
            if (response.status === 'connected') {
                loggedIn = true;
                checkLike();
            } else {
                login();
            }
        });
    };

    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    function login() {
        FB.login(function (response) {
            if (response.authResponse) {
                FB.api('/me', function (response) {
                    loggedIn = true;
                    checkLike();
                });
            } else {
                $("#wallLogin").show();
            }
        }, {scope: 'email,user_likes'});
    }

    function checkLike() {
        /* make the API call */
        FB.api(
            "/me/likes/112914959386944",
            function (response) {
                if (response && !response.error) {
                    if (response.data.length == 0) {
                        $("#wall").show();
                    }
                }
            }
        );
    }

    var timer = setInterval(function () {
        if (lostFocus == 0 && loggedIn) {
            if (!document.hasFocus()) {
                lostFocus = 1;
            }
        }

        if (lostFocus == 1) {
            if (document.hasFocus()) {
                lostFocus = 2;
                $("#wall").hide();
            }
        }
    }, 500);


    $("#close").click(function () {
        $("#wall").hide();
    });

    $("#gift").click(function () {
        FB.api('/me?fields=email,name', function (response) {
            alert(response.name + " we sent you a coupon at " + response.email);
        });

    });

    function postLogin() {
        $("#wallLogin").hide();
        checkLike();
    }
</script>

<style>
    #gifts {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #wall, #wallLogin {
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        position: absolute;
        background: rgba(0, 0, 0, 0.75);
    }

    #container {
        height: 100%;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
    }

    #dialog {
        text-align: center;
    }

    #close {
        width: 25px;
        height: 25px;
    }

    #text {
        color: white;
    }
</style>
<?php

