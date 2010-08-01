<?php

    /**
     * Adds
     * <code>
     * <?= $this->spoiler('Json is the murderer', 'Click here to reveal the murderer'); ?>
     * </code>
     *
     * Requires jQuery to be loaded before
     *
     * Based on the technique found on @see http://css-tricks.com/examples/SpoilerRevealer/
     *
     * @author chelmertz
     */
    class Hz_View_Helper_Spoiler extends Zend_View_Helper_Abstract {

        const STANDARD_REPLACEMENT = 'Reveal spoiler';

        /**
         * Appends logic in JS script, but only once
         *
         * @return void
         */
        private function _appendScript() {
            if(strpos((string) $this->view->headScript(), '.spoiler') !== false) {
                return;
            }
            $js = <<<SCRIPT
       $(function() {
           $('.spoiler').each(function() {
                var spoiler = $(this);
                var replacement = spoiler.attr('title');
                spoiler
                    .before('<span class="spoiler_placeholder">'+replacement+'</span>')
                    .hide()
                    .prev()
                        .click(function(){
                            var replacement = $(this);
                            replacement
                                .fadeOut(200)
                                .next()
                                    .attr('title', '')
                                    .fadeIn(600)
                                    .prev()
                                .remove();
                        });
           });
       });
SCRIPT;
            $this->view->headScript()->appendScript($js);
        }

        /**
         * Generates HTML output
         *
         * @param string $content
         * @return string
         */
        private function _applySpoiler($content, $replacement) {
            return '<span class="spoiler" title="'.$replacement.'">'.$content.'</span>';
        }

        /**
         * @param string $content
         * @param string $replacement
         * @return string
         */
        public function spoiler($content, $replacement = self::STANDARD_REPLACEMENT) {
            $this->_appendScript();
            return $this->_applySpoiler($content, $replacement);
        }

    }
