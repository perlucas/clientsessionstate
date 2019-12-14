<?php

namespace ClientSessionState\Impl;
use ClientSessionState\Contracts\SessionDataFormatter;

class JavascriptFormatter implements SessionDataFormatter
{
    /**
     * formats the encrypted session data
     *
     * @param string $input
     * @param mixed $arg1, $arg2...
     * @return mixed
     */
    public function format(string $input, ...$args)
    {
        $sdkAlias = count($args) && strlen($arg[0])
            ? $args[0]
            : 'ClientSession';

        \ob_start();
        ?>
        <script>
            if (typeof <?=$sdkAlias?> === "undefined") {
                var <?=$sdkAlias?> = {

                    toString : function(prepend = null, append = null) {
                        var prep = typeof prepend === 'string' && prepend
                            ? prepend : '';
                        var app = typeof append === 'string' && append
                            ? append : '';
                        return prep + this.encoded + append;
                    },

                    addToForm : function(form, properties = {}) {
                        var formElement = typeof form === 'string'
                            ? document.getElementById(form) : form;
                        var defaultProperties = {
                            name: 'session',
                            type: 'hidden'
                        };
                        var input = document.createElement('input');
                        if (typeof properties === 'object') {
                            for (prop in properties) defaultProperties[prop] = properties[prop];
                        }
                        defaultProperties.value = this.data;
                        for (prop in defaultProperties) input[prop] = defaultProperties[prop];
                        formElement.appendChild(input);
                    }

                };
            }
            <?=$sdkAlias?>.data = "<?=$input?>";
        </script>
        <?php
        return \ob_get_clean();
    }
}