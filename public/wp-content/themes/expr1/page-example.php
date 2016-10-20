
<?php
/**
  Template Name: Example
 * @package WordPress
 * @subpackage Simplest_Site
 * @since Simplest Site 1.0
 */
use spock\helper\Nonce_Wrapper;
$nonce_obj = new Nonce_Wrapper('nonce', 60*60);

// Example of verifying nonce to form submit
$saved = '';
  if(isset($_POST['sbm'])) {
      $nonce = $_POST['_wpnonce'];
      $saved = 'data hasn`t saved';
      $nonce_ver_obj = new Nonce_Wrapper('nonce', 60*60);
      if($nonce_ver_obj->verify_nonce($nonce)) {

        // safe to submit data
        $saved = '<h3 style="color:red;">data has saved</h3>';

      } else {

        die('security check!');

      }
  }

// Example of verifying nonce to url
  $checked_url = '';
  if(isset($_GET['_wpnonce'])) {

    $nonce = $_GET['_wpnonce'];
    $nonce_ver_obj = new Nonce_Wrapper('nonce', 60*60);
    if($nonce_ver_obj->verify_nonce($nonce)) {

      $checked_url = '<h3 style="color:red;">The url has checked</h3>';

    } else {

      die('security check!');

    }
  }

// Example nonce url
  $nonce_url = $nonce_obj->create_nonce_url( '/nonce-page' );

get_header();
?>

  <!-- The data saved informer -->
  <?php echo $saved; ?>

  <!-- Example nonce form -->
  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
    <form name="nonce" id="nonce" method="post">
      <input type="text" name="sender">
      <!-- creating nonce field -->
      <?php echo $nonce_obj->create_nonce_field(); ?>
      <input type="submit" name="sbm">
    </form>

    <!-- Example nonce url -->
    <a href="<?php echo $nonce_url; ?>">Example nonce url</a>
    <?php echo $checked_url; ?>

    <?php

      while ( have_posts() ) : the_post();

        get_template_part( 'template-parts/content', 'page' );

        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) :
          comments_template();
        endif;

      endwhile; // End of the loop.
      ?>

    </main><!-- #main -->
  </div><!-- #primary -->

<?php
get_sidebar();
get_footer();
