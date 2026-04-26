	</main>
	<footer class="site-footer">
		<p>Waldorfkindergarten Idstein · Limburger Str. 79 · 65510 Idstein · 06126/92141</p>
		<p><a href="mailto:info@waldorfkindergarten-idstein.de">info@waldorfkindergarten-idstein.de</a></p>
		<div class="footer-links">
			<?php foreach ( waldorf_idstein_footer_links() as $item ) : ?>
				<a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
			<?php endforeach; ?>
		</div>
	</footer>
</div>
<button class="wash-toggle" type="button">Animierter Hintergrund an</button>
<?php wp_footer(); ?>
</body>
</html>
