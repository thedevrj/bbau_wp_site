
<div class="bcf-wrapper">
    <div class="container">
        <nav aria-label="breadcrumb" class="bcf-nav" id="bcf-nav">
            <ul class="bcf-list">
                <li class="bcf-item">
                    <a href="<?php echo esc_url( home_url('/') ); ?>" class="bcf-link">
                        <span class="bcf-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                            </svg>
                        </span>
                        <span>Home</span>
                    </a>
                </li>

                <?php
                if ( is_page() ) {
                    global $post;
                    $parents   = array();
                    $parent_id = $post->post_parent;

                    while ( $parent_id ) {
                        $parent_page = get_post( $parent_id );
                        if ( ! $parent_page ) break;
                        $parents[] = $parent_page;
                        $parent_id = $parent_page->post_parent;
                    }
                    $parents = array_reverse( $parents );

                    foreach ( $parents as $parent ) {
                        printf(
                            '<li class="bcf-item">
                                <span class="bcf-sep">/</span>
                                <a href="%1$s" class="bcf-link bcf-text" data-full="%2$s">%2$s</a>
                            </li>',
                            esc_url( get_permalink( $parent->ID ) ),
                            esc_html( $parent->post_title )
                        );
                    }
                }
                ?>

                <li class="bcf-item bcf-active" aria-current="page">
                    <span class="bcf-sep">/</span>
                    <span class="bcf-link bcf-chip bcf-text" data-full="<?php echo esc_attr( get_the_title() ); ?>"><?php echo esc_html( get_the_title() ); ?></span>
                </li>
            </ul>
        </nav>
    </div>
</div>
<style>

.bcf-wrapper {
  padding: 20px 0 !important;
  margin: 0 !important;
}

.bcf-nav {
  padding: 0 !important;
  margin: 0 !important;
}

.bcf-list {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  list-style: none;
  margin: 0 !important;
  padding: 3px 3px !important;
  gap: 4px;
  row-gap: 6px;
  background: #8B1A1A;
  border: 1px solid #e6ddc9;
  border-radius: 10px;
  width: fit-content;
  max-width: 100%;
}

.bcf-item {
  display: flex;
  align-items: center;
  gap: 6px;
}

.bcf-sep {
  color: rgba(255, 255, 255, 0.6);
  font-size: 14px;
  margin: 0 4px;
}

.bcf-link {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  text-decoration: none;
  font-size: 14px;
  font-weight: 700;
  color: #ffffff !important;
  white-space: nowrap;
  transition: opacity 0.2s ease;
}

.bcf-icon {
  width: 16px;
  height: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.bcf-icon svg {
  width: 100%;
  height: 100%;
  fill: currentColor;
}

a.bcf-link:hover {
  opacity: 0.8;
  text-decoration: underline;
  text-underline-offset: 2px;
}

.bcf-chip {
  background: #ffffff;
  color: #8B1A1A !important;
  font-weight: 700;
  padding: 8px 18px !important;
  border-radius: 6px;
  cursor: default;
}

@media (max-width: 576px) {

  .bcf-wrapper {
    padding: 14px 0 !important;
  }

  .bcf-list {
    background: transparent !important;
    border: none !important;
    box-shadow: none !important;
    padding: 0 !important;
    width: 100%;
    gap: 0;
  }

  .bcf-item {
    gap: 0;
  }

  .bcf-item + .bcf-item::before {
    content: "/";
    color: #999999;
    margin: 0 6px;
    font-weight: 400;
  }

  .bcf-sep {
    display: none;
  }

  .bcf-icon {
    display: none;
  }

  .bcf-link {
    font-size: 13px;
    font-weight: 400;
    color: #6b6b6b !important;
    background: none !important;
    padding: 0 !important;
    border-radius: 0 !important;
  }

  .bcf-chip {
    background: none !important;
    color: #c0392b !important;
    font-weight: 700;
    padding: 0 !important;
  }
}
</style>
<script>
(function () {
    var nav = document.getElementById('bcf-nav');
    if (!nav) return;
    var max = window.innerWidth <= 480 ? 26 : 55;
    nav.querySelectorAll('.bcf-text[data-full]').forEach(function (el) {
        var full = el.getAttribute('data-full');
        if (full.length > max) {
            el.textContent = full.slice(0, max - 1) + '…';
            el.setAttribute('title', full);
        }
    });
})();
</script>