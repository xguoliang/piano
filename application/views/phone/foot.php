<footer>
    <ul>
        <li class="<?php
        if ($nav == 1) {
            echo 'active';
        }
        ?>">
            <a href="<?php echo base_url(); ?>">
                <i class="footer-icon footer-icon1"></i>
                <p>首页</p>
            </a>
        </li>
        <li class="<?php
        if ($nav == 2) {
            echo 'active';
        }
        ?>">
            <a href="#">
                <i class="footer-icon footer-icon2"></i>
                <p>分类</p>
            </a>
        </li>
        <li class="<?php
        if ($nav == 3) {
            echo 'active';
        }
        ?>">
            <a href="<?php echo base_url(); ?>User/Product/PFindGood.html">
                <i class="footer-icon footer-icon3"></i>
                <p>发现</p>
            </a>
        </li>
        <li class="<?php
        if ($nav == 4) {
            echo 'active';
        }
        ?>">
            <a href="<?php echo base_url(); ?>User/Login/My.html">
                <i class="footer-icon footer-icon4"></i>
                <p>我的</p>
            </a>
        </li>
    </ul>
</footer>