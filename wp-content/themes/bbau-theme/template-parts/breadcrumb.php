    <!-- Breadcrumb Section -->
    <div class="breadcrumb-wrapper">
        <div class="container ">
            <ul class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?php echo home_url('/'); ?>" class="breadcrumb-link">
                        <span class="breadcrumb-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                            </svg>
                        </span>
                        <span>Home</span>
                    </a>
                </li>
                <?php
                    if (is_page()) {
                        global $post;

                        $parents = [];
                        $parent_id = $post->post_parent;

                        // Collect all parent pages
                        while ($parent_id) {
                            $page = get_post($parent_id);
                            $parents[] = $page;
                            $parent_id = $page->post_parent;
                        }

                        // Reverse to get correct order
                        $parents = array_reverse($parents);

                        // Print parent pages
                        foreach ($parents as $parent) {
                            echo '<li class="breadcrumb-item">
                                    <a href="' . get_permalink($parent->ID) . '" class="breadcrumb-link">
                                        <span class="breadcrumb-code">&lt;/&gt;</span>
                                        <span>' . esc_html($parent->post_title) . '</span>
                                    </a>
                                </li>';
                        }
                    }
                ?>

                <!-- Current Page -->
                <li class="breadcrumb-item active">
                    <a href="<?php the_permalink(); ?>" class="breadcrumb-link">
                    <span class="breadcrumb-code">&lt;/&gt;</span>
                    <span><?php the_title(); ?></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- End Breadcrumb -->