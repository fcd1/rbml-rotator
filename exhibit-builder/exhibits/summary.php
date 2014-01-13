      <?php echo head(array('title' => metadata('exhibit', 'title'), 'bodyclass'=>'exhibits summary')); ?>
      <table class="layoutTable">
        <tr>
          <td style="width:225px" class="exhibit-nav">
            <div id="nav-container">
              <ul class="exhibit-section-nav current" style="padding:0; margin:0;background:#9cf;">
                <li style="background:#9cf;font-weight:bold;">
                  <?php
                    $title_link = exhibit_builder_link_to_exhibit(get_current_record('exhibit'),
								  "Home",
								  array('class' => 'exhibit-section-title current',
									'style' => 'color:#369'));
                    echo $title_link;
                  ?>
                </li>
              </ul>
              <div id="secondary">
                <ul class="exhibit-section-nav">
                  <?php set_exhibit_pages_for_loop_by_exhibit(); ?>
                  <?php foreach (loop('exhibit_page') as $exhibitPage): ?>
                    <?php 
                      $html = '<li class="exhibit-section-title">' . 
                              '<a class="exhibit-section-title" href="' . 
                              exhibit_builder_exhibit_uri(get_current_record('exhibit'), 
							  $exhibitPage) . '">'.
                              cul_insert_angle_brackets(metadata($exhibitPage, 'title')) . '</a></li>';
                      echo $html;
                    ?>
                  <?php endforeach; ?>
                </ul>
              </div> <!--end id="secondary"-->
            </div> <!--end id="nav-container"-->
          </td>
          <td class="content">
            <div class="exhibit-description">
              <?php echo $exhibit->description; ?>
            </div> <!--end class="exhibit-description"-->
            <div id="exhibit-credits">	
              <h3>Exhibit Curator</h3>
              <p>
                <?php echo $exhibit->credits; ?>
              </p>
            </div> <!--end id="exhibit-credits"-->
            <div id="exhibit-sections">
              <?php 
                if (get_theme_option('Home Sections')): 
              ?>
                <?php set_exhibit_pages_for_loop_by_exhibit(); ?>
                <?php foreach (loop('exhibit_page') as $exhibitPage): ?>
                  <?php 
                    $html = '<h3><a href="' . 
                            exhibit_builder_exhibit_uri(get_current_record('exhibit'), 
							$exhibitPage) . '">'.
                            cul_insert_angle_brackets(metadata($exhibitPage, 'title')) . ' &raquo;</a></h3>';
                    echo $html;
                    $pageText = exhibit_builder_page_text(1);
                    echo $pageText;
                  ?>
                <?php endforeach; ?>
              <?php endif; ?>
            </div> <!--end id="exhibit-credits"-->
            <div style="float:right;font-style:italic">
              <?php 
                $resolverURL = "";
                if ($resolverURL != ""): 
              ?>
                <p>Bookmark this page as: <a href="<?=$resolverURL;?>"><?=$resolverURL;?></a></p></div>
              <?php endif; ?>
            </div>
          </td>
        </tr>
      </table>
      <?php echo foot(); ?>

