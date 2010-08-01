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

        /**
         *
         * @var string
         */
        private $_replacement;

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
           $('<span class="spoiler_placeholder">$this->_replacement</span>')
                .insertBefore('.spoiler')
                .click(function() {
                    $(this)
                        .fadeOut(200)
                        .next()
                        .fadeIn(600);

                })
                .next()
                    .hide();
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
        private function _applySpoiler($content) {
            return '<span class="spoiler">'.$content.'</span>';
        }

        /**
         * @param string $content
         * @param string $replacement
         * @return string
         */
        public function spoiler($content, $replacement = self::STANDARD_REPLACEMENT) {
            $this->_replacement = (string) $replacement;
            $this->_appendScript();
            return $this->_applySpoiler($content);
        }

    }
