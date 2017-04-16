<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_related
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
$app    = JFactory::getApplication();
$tpath   = JURI::base(true).'/templates/'.$app->getTemplate().'/';
$widthchoosen = $params->get('widthchoosen', '360');
$heightchoosen = $params->get('heightchoosen', '240');
$cropchoosen = $params->get('cropchoosen', '4:3');
$default_image = $params->get('default_image', 'images/sem_imagem.png');
$maxLimit = $params->get('max_limit', '144');
$items_in_row = $params->get('items_in_row', '4');
$show_title = $params->get('show_title', '1')
?>

  <?php foreach ($list as $i=>$item) :  ?>
    <?php if (($i % $items_in_row) == '0') :?>
    <div class="mynews">
   <ul class="latestnews<?php echo $moduleclass_sfx; ?>">
  <?php endif;?>
  <li class="col-md-3 span3 uk-scrollspy-init-inview uk-scrollspy-inview uk-animation-scale-up" itemscope itemtype="https://schema.org/Article">
      
    <div class="image_related_news col-md-12 span12">
<?php

$thumbsnippet = $tpath.'html/mod_'.$module->name.'/assets/smart/image.php?width='.$widthchoosen.'&height='.$heightchoosen.'&cropratio='.$cropchoosen.'&image='.JURI::root();
        preg_match('/(?<!_)src=([\'"])?(.*?)\\1/',$item->introtext, $matches);
                ?>


       <?php
       if (empty($matches[2]) and (empty(json_decode($item->images)->image_fulltext))  and (!empty(json_decode($item->images)->image_intro)) ){
            echo  '<a href="'. $item->route.'" itemprop="url"><img src="'.$thumbsnippet.json_decode($item->images)->image_intro.'" class="resize" /></a>';
        }
       if (empty($matches[2]) and (!empty(json_decode($item->images)->image_fulltext))  and (empty(json_decode($item->images)->image_intro)) ){
            echo  '<a href="'. $item->route.'" itemprop="url"><img src="'.$thumbsnippet.json_decode($item->images)->image_fulltext.'" class="resize" /></a>';
        }
        if (empty($matches[2]) and (!empty(json_decode($item->images)->image_fulltext))  and (!empty(json_decode($item->images)->image_intro)) ){
            echo  '<a href="'. $item->route.'" itemprop="url"><img src="'.$thumbsnippet.json_decode($item->images)->image_intro.'" class="resize" /></a>';
        }
       if (!empty($matches[2]) and (empty(json_decode($item->images)->image_fulltext))  and (empty(json_decode($item->images)->image_intro)) ){
            echo  '<a href="'. $item->route.'" itemprop="url"><img src="'.$thumbsnippet.$matches[2].'" class="resize" /></a>';
        }
        if (empty($matches[2]) and (empty(json_decode($item->images)->image_fulltext))  and (empty(json_decode($item->images)->image_intro)) ){
            echo  '<a href="'. $item->route.'" itemprop="url"><img src="'.$thumbsnippet.$default_image.'" class="resize" /></a>';
        }
        ?>
    </div>    
    <div class="header_related_news col-md-12">


     <?php if ($show_title == '1') : ?>
      <h4 itemprop="name">
        <?php echo $item->title; ?>
      </h4>
     <?php endif;?>

      <div class="relateditem-date">
          <i class="icon icon-calendar"></i> <?php echo JHtml::_('date', $item->created, 'd/m/Y'); ?>
      </div>

         

     </div>


    <?php 

         if (!empty($item->introtext)) {
			     $text = $item->introtext;
		      } else {
			$text = $item->texfull;
		}

         $text = preg_replace("/\r\n|\r|\n/", " ", $text);
					// Next, replace <br /> tags with \n
					$text = preg_replace("/<BR[^>]*>/i", " ", $text);
					// Replace <p> tags with \n\n
					$text = preg_replace("/<P[^>]*>/i", " ", $text);
					// Strip all tags
					$text = strip_tags($text);
					// Truncate
					$text = substr($text, 0, $maxLimit);
					//$text = String::truncate($text, $maxLimit, '...', true);
					// Pop off the last word in case it got cut in the middle
					$text = preg_replace("/[.,!?:;]? [^ ]*$/", " ", $text);
					// Add ... to the end of the article.
					$text = trim($text) . '...<p><a class="btn button btn btn-primary readmore" href="'.$item->route.'" itemprop="url">'. JText::_('COM_CONTENT_READ_MORE_TITLE').'</a></p>' ;
					// Replace \n with <br />
					$text = str_replace("\n", " ", $text);
          
        echo $text;

          ?> 
   



  </li>
  <?php if (($i % $items_in_row) == '3') :?>
    </ul></div>
 <?php endif;?>
  <?php endforeach; ?>
