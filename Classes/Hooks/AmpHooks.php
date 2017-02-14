<?php
namespace Cobweb\AcceleratedMobilePages\Hooks;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2017 Roberto Presedo <typo3@cobweb.ch>, Cobweb
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * AmpHooks
 */
class AmpHooks
{
    /**
     * Hook to perform at the end of the frontend rendering, right before sending the content to the browser
     * @param array $params
     * @param \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $pObj
     */
    public function hook_eofe($params, &$pObj)
    {
        $this->changeImageTags($pObj->content);
    }

    /**
     * Change the image tags to make them APM compatible
     * @param $content
     */
    protected function changeImageTags(&$content)
    {
        $gpVar = GeneralUtility::_GP('tx_accelerated_mobile_pages');
        if (is_array($gpVar) && isset($gpVar['amp'])) {
            preg_match_all('/<img[^>]+>/i', $content, $images);
            foreach ($images[0] as $image) {

                $layout = 'container';
                $hasHeight = strpos($image, ' height =') > 0 ? true : (strpos($image, ' height=') > 0 ? true : false);
                $hasWidth = strpos($image, ' width =') > 0 ? true : strpos($image, ' width=') > 0 ? true : false;
                $hasSizes = strpos($image, ' sizes =') > 0 ? true : strpos($image, ' sizes=') > 0 ? true : false;

                if ($hasSizes) $layout = 'responsive';
                elseif ($hasWidth) $layout = 'fixed';
                elseif ($hasHeight) $layout = 'fixed-height';

                $newImage = str_replace('<img ', '<amp-img layout="' . $layout . '" ', $image);

                $content = str_replace($image, $newImage, $content);
            }
        }
    }
}
