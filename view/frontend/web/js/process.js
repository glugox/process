/**
 * This file is part of Glugox.
 *
 * (c) Glugox <glugox@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
/*jshint jquery:true*/
define([
    'jquery',
    'jquery/ui'
], function ($) {
    $.widget('glugox.process', {
        options: {
            processGetUrl:'',
            tempDir:'',
            hashBase:'',
            texts: {
                running: ' - Please wait...',
                completed: ' - Opening...'
            },
            iconRunning: ''
        },
        isRunning: false,
        hashIndex: 1,
        instances:[],
        _create: function () {
            var o = this;
            $(".glugox.process").click(function () {

                if(o.isRunning){
                    return false;
                }
                var btn = this;
                var processInstanceCode = o._getHashCode();
                $(this).attr("data-process-id", processInstanceCode);
                o.instances[processInstanceCode] = {element:$(this), progress:0, status:0 };

                o._updateElementInfo(processInstanceCode);

                o.isRunning = true;
                var url = $(btn).attr("href");
                console.log("Request :: " + url);
                jQuery.ajax({
                    url: url,
                    type: "POST",
                    dataType: "json",
                    data: {process_instance_code:processInstanceCode}
                }).success(function(data){
                    o.instances[processInstanceCode].progress = 100;
                    o._updateElementInfo(processInstanceCode);
                    window.location.href = data.download_url;
                }).complete(function(){
                    //
                });

                o.processInterval = setTimeout(function(){
                    o._getProcessInfo(processInstanceCode, o);

                }, 1000);


                return false;
            });

        },

        /**
         *
         * @param processInstanceCode
         * @private
         */
        _updateElementInfo: function(processInstanceCode){
            var o = this;
            var el = $("[data-process-id='" + processInstanceCode + "']");
            if($(el).length){
                var data = this.instances[processInstanceCode];
                if(data){
                    var progress = " - " + data.progress + "%";
                    if(!$(el).find('.g-process-info').length){
                        $(el).append("<span class='g-process-info'></span>");
                    }
                    if(!$(el).find('.g-process-progress').length){
                        $(el).append("<span class='g-process-progress'></span>");
                    }
                    if(data.progress == 0 && this.options.texts.running){
                        progress = this.options.texts.running;
                    }else if(data.progress == 100 && this.options.texts.completed){
                        progress = this.options.texts.completed;
                        var resetTimeout = setTimeout(function(){
                            $(el).find('.g-process-progress').html("");
                            o.isRunning = false;
                        }, 10000);
                    }
                    $(el).find('.g-process-progress').html(progress);
                }
            }
        },

        /**
         *
         * @returns {string}
         * @private
         */
        _getHashCode: function () {
            var indexStr = this.hashIndex < 10 ? ("0"+this.hashIndex) : (""+this.hashIndex);
            this.hashIndex++;
            return this.options.hashBase + indexStr;

        },


        /**
         *
         * @param processInstanceCode
         * @private
         */
        _getProcessInfo: function(processInstanceCode, o){

            if(!o){
                o = this;
            }
            var prUrl = o.options.processGetUrl;

            jQuery.ajax({
                url: prUrl,
                type: "POST",
                dataType: "json",
                data: {process_instance_code:processInstanceCode}
            }).success(function(data){

                // on complete we are setting progress to 100, but if the process is cached, the ajax
                // call will return 0. For those and all other symptoms, check which is greater.
                if(parseInt(data.process.progress) > parseInt(o.instances[processInstanceCode].progress)){
                    o.instances[processInstanceCode].progress = parseInt(data.process.progress);
                    o._updateElementInfo(processInstanceCode);
                }

                if(o.isRunning){
                    o._getProcessInfo(processInstanceCode, o);
                }
            });

        }
    });

    return $.glugox.process;
});
