<?php

?>

<nav class="c-circle-menu js-menu">

    <button class="c-circle-menu__toggle js-menu-toggle">
        <span>Toggle</span>
    </button>

    <ul class="c-circle-menu__items">
        <li class="c-circle-menu__item">
            <a href="../saved/" class="c-circle-menu__link">
                <!-- <img src="img/house.svg" alt=""> -->
                <i class="far fa-bookmark tooltip">
                <span class="tooltiptext">ذخیره شده</span>
                </i>
            </a>
        </li>
        <li class="c-circle-menu__item">
            <a href="../shop/" class="c-circle-menu__link">
                <!-- <img src="img/photo.svg" alt=""> -->
                <i class="fas fa-home tooltip">
                <span class="tooltiptext">فروشگاه</span>
                </i>
            </a>
        </li>
        <li class="c-circle-menu__item">
            <a href="../userInfo/" class="c-circle-menu__link" id="userConf">
                <!-- <img src="img/pin.svg" alt=""> -->
                <i class="fas fa-user-cog checkLogin tooltip">
                <span style="display:none;" class="userConfigurationRemain"></span>
                <span class="tooltiptext">اطلاعات شخصی</span>
                </i>
            </a>
        </li>
        <li class="c-circle-menu__item">
            <a href="../cartList/" class="c-circle-menu__link">
                <!-- <img src="img/search.svg" alt=""> -->
                <i class="fas fa-clipboard-list checkLogin tooltip">
                <span class="tooltiptext">لیست خریدها</span>
                </i>
            </a>
        </li>
        <li class="c-circle-menu__item">
            <a href="../cart/" class="c-circle-menu__link" id="basket">
                <!-- <img src="img/tools.svg" alt=""> -->
                <i class="fas fa-shopping-cart checkLogin tooltip">
                <span style="display:none;" class="basketNotificationButton"></span>
                <span class="tooltiptext">سبد خرید</span>
                </i>
            </a>
        </li>
    </ul>
    
    <div id="particles-js" class="c-circle-menu__mask js-menu-mask"></div>

    <script src="/js/src/particles.js"></script>
    <script src="/js/src/app_particles.js"></script>
    
</nav>

