<?php
/**
 * /**
 * Template Name: Dl and Demo
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Iebase
 */
$get_down = get_query_var( 'down' );
$get_demo = get_query_var( 'demo' );

if ($get_demo){
  $demo_slug = $_GET["demo"];
  $demo_id = iebase_get_post_id_by_slug($demo_slug);
  get_header('sim');
  $ie_demo = get_post_meta($demo_id  , 'iebase_demo_links', true);
} else {
  $down_slug = $_GET["down"];
  $down_id = iebase_get_post_id_by_slug($down_slug);
  get_header();
  $ie_download = get_post_meta($down_id , 'iebase_download_links', true);
  $ie_item_title = mb_strimwidth(get_post($down_id)->post_title, 0, 50, '...');
  $ie_item_official = get_post_meta( $down_id, 'iebase_download_official', true );
  $ie_item_license = get_post_meta($down_id , 'iebase_download_license', true);
}
  $ie_item_contact = get_permalink( get_page_by_path( 'contact' ) );
?>

<?php if ($get_demo): ?>
  <body class="full-screen-preview">
  <div id="switcher">

	<div class="center">

		<div class="logo">
    <?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) : ?>
      <?php the_custom_logo() ?>
    <?php else: ?>
      <a class='ie-logo-link' href='<?php echo esc_url( home_url( '/' ) ); ?>'><?php bloginfo( 'name' ); ?></a>
    <?php endif; ?>
		</div>

		<div class="fbar-separator"></div>

		<div class="responsive responsive_buttons_demo">
			<a href="#" class="desktop active" title="View Desktop Version">
				<svg xmlns="http://www.w3.org/2000/svg" width="1920" height="2048" viewbox="0 0 2048 1920" preserveaspectratio="xMidYMid meet"><path d="M1792 1120V288c0-8.667-3.167-16.167-9.5-22.5s-13.833-9.5-22.5-9.5H160c-8.667 0-16.167 3.167-22.5 9.5S128 279.333 128 288v832c0 8.667 3.167 16.167 9.5 22.5s13.833 9.5 22.5 9.5h1600c8.667 0 16.167-3.167 22.5-9.5s9.5-13.833 9.5-22.5zm128-832v1088c0 44-15.667 81.667-47 113s-69 47-113 47h-544c0 24.667 5.333 50.5 16 77.5s21.333 50.667 32 71 16 34.833 16 43.5c0 17.333-6.333 32.333-19 45s-27.667 19-45 19H704c-17.333 0-32.333-6.333-45-19s-19-27.667-19-45c0-9.333 5.333-24 16-44s21.333-43.333 32-70 16-52.667 16-78H160c-44 0-81.667-15.667-113-47s-47-69-47-113V288c0-44 15.667-81.667 47-113s69-47 113-47h1600c44 0 81.667 15.667 113 47s47 69 47 113z"/></svg>
			</a>
			<a href="#" class="tabletlandscape" title="View Tablet Landscape (1024x768)">
				<svg xmlns="http://www.w3.org/2000/svg" height="1792" width="1792" viewbox="0 0 1792 1792" preserveaspectratio="xMidYMid meet"><path d="M960 1408q0-26-19-45t-45-19-45 19-19 45 19 45 45 19 45-19 19-45zm384-160v-960q0-13-9.5-22.5t-22.5-9.5h-832q-13 0-22.5 9.5t-9.5 22.5v960q0 13 9.5 22.5t22.5 9.5h832q13 0 22.5-9.5t9.5-22.5zm128-960v1088q0 66-47 113t-113 47h-832q-66 0-113-47t-47-113v-1088q0-66 47-113t113-47h832q66 0 113 47t47 113z"/></svg>
			</a>
			<a href="#" class="tabletportrait" title="View Tablet Portrait (768x1024)">
				<svg xmlns="http://www.w3.org/2000/svg" height="1792" width="1792" viewbox="0 0 1792 1792" preserveaspectratio="xMidYMid meet"><path d="M960 1408q0-26-19-45t-45-19-45 19-19 45 19 45 45 19 45-19 19-45zm384-160v-960q0-13-9.5-22.5t-22.5-9.5h-832q-13 0-22.5 9.5t-9.5 22.5v960q0 13 9.5 22.5t22.5 9.5h832q13 0 22.5-9.5t9.5-22.5zm128-960v1088q0 66-47 113t-113 47h-832q-66 0-113-47t-47-113v-1088q0-66 47-113t113-47h832q66 0 113 47t47 113z"/></svg>
			</a>
			<a href="#" class="mobilelandscape" title="View Mobile Landscape (480x320)">
				<svg xmlns="http://www.w3.org/2000/svg" height="1792" width="1792" viewbox="0 0 1792 1792" preserveaspectratio="xMidYMid meet"><path d="M976 1408q0-33-23.5-56.5t-56.5-23.5-56.5 23.5-23.5 56.5 23.5 56.5 56.5 23.5 56.5-23.5 23.5-56.5zm208-160v-704q0-13-9.5-22.5t-22.5-9.5h-512q-13 0-22.5 9.5t-9.5 22.5v704q0 13 9.5 22.5t22.5 9.5h512q13 0 22.5-9.5t9.5-22.5zm-192-848q0-16-16-16h-160q-16 0-16 16t16 16h160q16 0 16-16zm288-16v1024q0 52-38 90t-90 38h-512q-52 0-90-38t-38-90v-1024q0-52 38-90t90-38h512q52 0 90 38t38 90z"/></svg>
			</a>
			<a href="#" class="mobileportrait" title="View Mobile Portrait (320x480)">
				<svg xmlns="http://www.w3.org/2000/svg" height="1792" width="1792" viewbox="0 0 1792 1792" preserveaspectratio="xMidYMid meet"><path d="M976 1408q0-33-23.5-56.5t-56.5-23.5-56.5 23.5-23.5 56.5 23.5 56.5 56.5 23.5 56.5-23.5 23.5-56.5zm208-160v-704q0-13-9.5-22.5t-22.5-9.5h-512q-13 0-22.5 9.5t-9.5 22.5v704q0 13 9.5 22.5t22.5 9.5h512q13 0 22.5-9.5t9.5-22.5zm-192-848q0-16-16-16h-160q-16 0-16 16t16 16h160q16 0 16-16zm288-16v1024q0 52-38 90t-90 38h-512q-52 0-90-38t-38-90v-1024q0-52 38-90t90-38h512q52 0 90 38t38 90z"/></svg>
			</a>
		</div>

		<ul class="links">
			<li class="purchase">
      <?php echo '<a id="clickthemefromdemo" class="livedemo-btn" href="' . esc_url( get_permalink($demo_id) ) . '" title="' . esc_html( get_the_title($demo_id) ) . '">' . esc_html__( 'Download Now', 'iebase' ) . '</a>'; ?>
			</li>
			<li class="hide-fbar">
				<a href="#" id="hide-demo-bar">
					<svg xmlns="http://www.w3.org/2000/svg" height="512" width="512" viewbox="0 0 512 512" preserveaspectratio="xMidYMid meet"><path d="M437.5 386.6L306.9 256l130.6-130.6c14.1-14.1 14.1-36.8 0-50.9s-36.8-14.1-50.9 0L256 205.1 125.4 74.5c-14.1-14.1-36.8-14.1-50.9 0s-14.1 36.8 0 50.9L205.1 256 74.5 386.6c-14.1 14.1-14.1 36.8 0 50.9s36.8 14.1 50.9 0L256 306.9l130.6 130.6c14.1 14.1 36.8 14.1 50.9 0 14-14.1 14-36.9 0-50.9z"/></svg>
					<svg xmlns="http://www.w3.org/2000/svg" height="32" width="32" viewbox="0 0 32 32" preserveaspectratio="xMidYMid meet"><path d="M14.77 23.795L5.185 14.2c-.88-.88-.88-2.317 0-3.195l.8-.8c.877-.878 2.316-.878 3.194 0l7.315 7.315 7.316-7.315c.878-.878 2.317-.878 3.194 0l.8.8c.88.878.88 2.316 0 3.195l-9.587 9.585c-.47.472-1.104.682-1.723.647-.62.035-1.25-.175-1.724-.647z" fill="#515151"/></svg>
				</a>
			</li>
		</ul>

	</div>
</div>
<iframe id="iframe" src="<?php echo $ie_demo;?>"
	frameborder="0" width="100%"></iframe>
  </body>
</html>
<?php elseif ($get_down): ?>
<div class='ie-wrapper'>

<div class='e-grid'>
  <div class='sim e-grid__col e-grid__col--center e-grid__col--4-4-s e-grid__col--3-4-m'>
    <article id='post-<?php the_ID(); ?>' <?php post_class('ie-post entry'); ?>>

      <div class='ie-content'>
        <?php do_action( 'dd_loop_start' ); ?>
        <p class="download_notice"><?php printf( __( 'Thank you for downloading <strong>%s</strong> from our site. The following are available links. And just press the button and the file will be automatically downloaded.', 'iebase' ), $ie_item_title); ?>
        </p>
        <div id="download-loading">
        <div id="download"><?php _e( 'Waiting <span id="numDiv">10</span> seconds...', 'iebase' ); ?></div>
        </div>
        <?php do_action( 'dd_loop_end' ); ?>
        <div class="download_note">
        <p><?php printf( __( 'You are now ready to download <strong>%s</strong> for free. Here are some notes:', 'iebase' ), $ie_item_title); ?></p>
        <p><?php printf( __( '1. How to use it? Please check our <a href="%s" target="_blank" rel="nofollow">use guide</a>.', 'iebase' ), $ie_item_official); ?></p>
        <p><?php printf( __( '2. IF The link is broken. Report it to us via <a href="%s" target="_blank" rel="nofollow">contact form</a> here.', 'iebase' ), $ie_item_contact); ?></p>
        <p><?php printf( __( '3.  Downloads are in full compliance with the %s.', 'iebase' ), $ie_item_license); ?></p>
        <p><?php _e( '4. We will not provide support for downloads.', 'iebase' ); ?></p>
        <p><?php _e( '5. If you need, please consider the purchase of an applicable support license from the developer.', 'iebase' ); ?></p>
        </div>
      </div>
      <div class='sim-footer'>
          <?php do_action( 'dd_footer_section' ); ?>
      </div>
    </article>
  </div>
</div>

</div>
<?php endif;?>
<?php if ($get_down) : get_footer(); endif;