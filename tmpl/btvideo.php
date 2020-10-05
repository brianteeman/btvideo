<?php
/**
 * Custom Fields - Video custom field
 *
 * @author brian@teeman.net
 * @copyright Copyright (c) 2020
 * @license GNU Public License v2
 * @link https://brian.teeman.net
 */

defined('_JEXEC') or die;

    // Match vimeo
    $vpattern = '/(http|https)?:\/\/(www\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|)(\d+)(?:|\/\?)/';
    // Match youtube
    $ypattern = '/(?:youtube(?:-nocookie)?\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/m';

    // url to test
    $str = $field->value;

    $vmatch = preg_match($vpattern, $str, $videoidv);
    $ymatch = preg_match($ypattern, $str, $videoidy);

 // if vimeo output the video id
    if ($vmatch) {
    $data = json_decode(file_get_contents('https://vimeo.com/api/v2/video/' . $videoidv[4] . '.json'))[0];

    $thumb = $data->thumbnail_large;

    // Loading the javascript and css
         JHtml::_('stylesheet', 'plg_fields_btvideo/lite-vimeo-embed.min.css', array('version' => 'auto', 'relative' => true));
         JHtml::_('script', 'plg_fields_btvideo/lite-vimeo-embed.min.js', array('version' => 'auto', 'relative' => true), array('defer' => 'defer'));


         ?>
        <lite-vimeo videoid="<?php echo $videoidv[4]; ?>" thumb="<?php echo $thumb; ?>" style="background-image: url('<?php echo $thumb; ?>')">
        	<div class="ltv-playbtn"></div>
        </lite-vimeo>
    <?php }
    // else if youtube output the video id
    else if ($ymatch) {
        // Loading the javascript and css
        JHtml::_('stylesheet', 'plg_fields_btvideo/lite-yt-embed.css', array('version' => 'auto', 'relative' => true));
        JHtml::_('script', 'plg_fields_btvideo/lite-yt-embed.js', array('version' => 'auto', 'relative' => true), array('defer' => 'defer'));
        ?>
        <lite-youtube videoid="<?php echo $videoidy[1]; ?>" style="background-image: url('https://i.ytimg.com/vi/<?php echo $videoidy[1]; ?>/hqdefault.jpg');">
            <button type="button" class="lty-playbtn" title="Play Video"></button>
        </lite-youtube>
    <?php }; ?>
