    
    <!-- Breadcrumb Section -->
<div class="breadcrumb-wrapper">
    <div class="container max_xl_w_1280">
        <ul class="breadcrumb">

            <!-- HOME -->
            <li class="breadcrumb-item">
                <a href="<?php echo home_url('/'); ?>" class="breadcrumb-link">
                    <span class="breadcrumb-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                        </svg>
                    </span>
                    <span>Home</span>
                </a>
            </li>

            <!-- ABOUT US (FORCED) -->
            <li class="breadcrumb-item">
                <a href="<?php echo site_url('/about-us'); ?>" class="breadcrumb-link">
                    <span class="breadcrumb-code">&lt;/&gt;</span>
                    <span>About Us</span>
                </a>
            </li>

            <!-- CURRENT PAGE -->
            <li class="breadcrumb-item">
                <span class="breadcrumb-link">
                    <span class="breadcrumb-code">&lt;/&gt;</span>
                    <span><?php the_title(); ?></span>
                </span>
            </li>

        </ul>
    </div>
</div>

