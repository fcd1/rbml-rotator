<!DOCTYPE html>
<html lang="<?php echo get_html_lang(); ?>">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if ($description = option('description')): ?>
      <meta name="description" content="<?php echo $description; ?>">
    <?php endif; ?>
    <title><?php echo option('site_title'); echo isset($title) ? ' | ' . strip_formatting($title) : ''; ?></title>

    <!-- Plugin Stuff -->
    <?php fire_plugin_hook('public_head', array('view'=>$this)); ?>
    <!-- Stylesheets -->
    <?php 
      queue_css_file('highslide','all',NULL,'/javascripts/highslide');
      queue_css_file('exhibitLayouts');
      queue_css_file('screen');
      echo head_css(); 
    ?>
    <?php
      queue_js_file('highslide/highslide');
      echo head_js();
    ?>
    <script type="text/javascript">
      hs.graphicsDir = "<?= url( 'application/views/scripts/javascripts/highslide/graphics/' ) ?>";
      hs.outlineType = 'rounded-white';
    </script>
    <?php
      $env = "";
      if (stristr($_SERVER['SERVER_NAME'], "-test")) {
        $env = "test";
      }
      else if (stristr($_SERVER['SERVER_NAME'], "-dev")) {
        $env = "dev";
      }
    ?>
    <?php if ($env == ""): ?>
      <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-796949-17']);
        _gaq.push(['_trackPageview']);
        (function() {
          var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
          ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') +
                   '.google-analytics.com/ga.js';
          var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
      </script>
    <?php endif; ?>
  </head>
  <?php echo body_tag(array('id' => @$bodyid, 'class' => @$bodyclass)); ?>
    <div id="wrap">
      <div class="headBack">
        <?php
          $exhibit_uri = exhibit_builder_exhibit_uri();
          $exhibit_nickname = '';
          if (stristr($exhibit_uri, 'nyccc'))
            $exhibit_nickname = "nyccc";
          else if (stristr($exhibit_uri, 'group_research'))
            $exhibit_nickname = "gr";
          else if (stristr($exhibit_uri, 'varsity-show'))
            $exhibit_nickname = "varsity";
          else if (stristr($exhibit_uri, 'political_ecologies'))
            $exhibit_nickname = "political_ecologies";
          else if (stristr($exhibit_uri, '/cc'))
            $exhibit_nickname = "ContempCiv";
          else if (stristr($exhibit_uri, '/lit_hum'))
            $exhibit_nickname = "LitHum";
          else if (stristr($exhibit_uri, '/pollock-s-oliver-twist'))
            $exhibit_nickname = "twist";
          $imageURL = getRandomImage($exhibit_nickname);
          if ($imageURL != "")
            echo "<div style=\"padding:0;margin:0;width:100%;background:url('$imageURL') top right no-repeat\">";
        ?>
        <?php
          $title = metadata('exhibit','title');
          $matches = explode(":",$title,2);
          if ($matches[0]):
        ?>
          <h1 class="exhHeader"><?php echo $matches[0]; ?>
        <?php endif;
          if ( array_key_exists(1,$matches) ):
            echo ':';
        ?>
        <span style="text-transform:none;font-size:24px"><?php echo $matches[1]; ?></span>
        <?php endif; ?>
          </h1>
        <?php if ($imageURL) echo "</div>"; ?>
      </div> <!--end class="headBack"-->
      <?php echo flash(); ?>

<?php
/******************************************************/
function getRandomImage($exhibit_nickname=null) {
  // choose a random image based on range
//  $path = $_SERVER['DOCUMENT_ROOT'];
//  $img_path = $path . $imageDir;
  $images = array();

  // fcd1, 8/17/13: getting exhibit() udefined error, so use metadata instead
  // $imageDir = opendir( PUBLIC_THEME_DIR . "/" . exhibit('theme') . "/images"  );
  //  $imageDir = opendir( PUBLIC_THEME_DIR . "/" . metadata(get_current_record('exhibit'),'theme') . "/images"  );
  $imageDir = opendir( PUBLIC_THEME_DIR . "/" . metadata('exhibit','theme') . "/images"  );

  while (($file = readdir($imageDir)) != false) {
    if (stristr($file, 'png') || stristr($file, 'jpg') || stristr($file, 'gif')) {
      if (!is_null($exhibit_nickname)) {
        if (stristr($file, $exhibit_nickname))
          array_push($images, $file);
      }
      else
        array_push($images, $file);
    } // end IF image file
  } // end WHILE
  if (count($images) == 0) return "";

  $intI = rand(0, (count($images) - 1) );
  $randomImage = $images[$intI];
  return img($randomImage);
} // end FUNCTION getRandomImage
?>

