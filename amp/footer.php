<footer class="amp-wp-footer">
    <div>
        <h2><?php echo esc_html( $this->get( 'blog_name' ) ); ?></h2>
        <p>
            <a href="/impressum/">Impressum</a>
        </p>
        <a href="#top" class="back-to-top"><?php _e( 'Back to top', 'amp' ); ?></a>
    </div>
    <?php
    echo get_PiwikPixel();
    ?>
    </footer>
