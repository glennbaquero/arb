/**
 * ==================================================================================
 * Response handler for success/error responses of Laravel.
 * 
 * Required libraries:
 * - Toastr
 * 
 * ==================================================================================
 **/
import toastr from 'toastr';
import css from '../../../node_modules/toastr/build/toastr.css';
import { bus } from '../bus.js';

export default {

    data() {
        return {
            errors: {},
        };
    },

    methods: {

        /**
         * Get field error
         *
         * @return string
         **/
        getError(field) {
            let error = '';

            /* Check if field exists */
            if(error = this.errors[field]) {

                if(typeof error === 'string') {
                    return error;
                }

                if(Array.isArray(error) && error.length > 0) {
                    return error[0];
                }
            }

            return error;
        },

        /**
         * Reset error variable
         *
         * IMPORTANT: Weird instance where the error var won't get updated immediately
         * causing the hasError(<field-name>) method to not show the error
         */
        resetErrors() {
            this.errors = {};
        },

        /**
         * Remove specified error
         * 
         * @param string field
         */
        removeError(field) {
            delete this.errors[field];
        },

        /**
         * Parses Laravel error responses
         *
         * @param mixed error
         * @param string title
         * @param boolean fade
         **/
        parseError(error, title = null, options = {}) {
            options.fade = false;
            return this.parseResponse(error, 'error', title, options);
        },

        /**
         * Parses Laravel warning responses
         *
         * @param mixed warning
         * @param string title
         * @param boolean fade
         **/
        parseWarning(warning, title = null, options = {}) {
            options.fade = false;
            return this.parseResponse(warning, 'warning', title, options);
        },        

        /**
         * Parses Laravel success responses
         *
         * @param mixed success
         * @param string title
         * @param boolean fade
         **/
        parseSuccess(success, title = null, options = {}) {
            options.fade = true;
            return this.parseResponse(success, 'success', title, options);
        },

        /**
         * Parses Laravel info responses
         *
         * @param mixed info
         * @param string title
         * @param boolean fade
         **/
        parseInfo(info, title = null, options = {}) {
            options.fade = true;
            return this.parseResponse(info, 'info', title, options);
        },        

        /**
         * Parse response array/object
         * 
         * @param  mixed result
         * @param  boolean type
         * @param  string title
         * @return string
         */
        parseResponse(result, type, title = null, options = {}) {
            /* Set needed variables */
            let message = '';
            let hasResponse = false, hasData = false, hasMultiError = false;


            if(typeof result === 'string') {
                message = result;
            }

            if(typeof result !== 'undefined') {
                /* Fetch and add in message */
                if(result.hasOwnProperty('message')) {
                    message = result.message;
                }
            }

            if(typeof result.data !== 'undefined') { //alert(result.response.status);
                if(result.data.hasOwnProperty('message') && result.data.message.length > 0) {
                    message = result.data.message;
                }
            }

            if(typeof result.response !== 'undefined') { //alert(result.response.status);
                /* Set needed checker vars; */
                hasData = result.response.hasOwnProperty('data');

                /* Fetch and add in response error message */
                if(hasData) {
                    if(result.response.data.hasOwnProperty('message') && result.response.data.message.length > 0) {
                        message = result.response.data.message;
                    }
                }

                /* Setup generic response messages only for error & warning response */
                if(type == 'error' || type == 'warning') {
                    switch(result.response.status) {
                        case 404: message = '404: Route is no longer available'; break;
                        case 405: message = '405: Request is not allowed'; break;
                        case 413: message = '413: File uploaded is too large, please upload a smaller file'; break;
                        case 419: message = '419: Authentication has expired, please refresh the page'; break;
                        case 422:

                            /* Check for errors field */
                            if(hasData) {
                                if(result.response.data.hasOwnProperty('errors')) { 
                                    let fieldsArray = result.response.data.errors; //console.log(fieldsArray);

                                    /* Set multi-line error trigger */
                                    hasMultiError = true;
                                    /* Set error var for hasError() */
                                    this.errors = fieldsArray;

                                    /* Fetch each error per item */
                                    for(let field in fieldsArray) { //console.log(field);
                                        for(let subfield in fieldsArray[field]) { //console.log(fieldsArray[field][subfield]);
                                            message += '<li>' + fieldsArray[field][subfield] + '</li>';
                                        }
                                    } //console.log(errorsMsg);
                                }
                            }

                            break;
                        case 500: message = 'Server error';
                            break;
                    }
                }
            }

            let systemType = document.head.querySelector('meta[name="system-type"]');

            if (systemType) {
                switch(systemType.content) {
                    case 'website':
                        return this.runDialog(message, title, type, options);
                    case 'system':
                    default:
                        return this.runToastr(message, title, type, options, hasMultiError);
                }
            } else {
                return this.runToastr(message, title, type, options, hasMultiError);
            }
        },

        runDialog(message, title, type, options) {
            return new Promise((resolve, reject) => {
                let params = {
                    title: title,
                    message: message,
                    type: type,
                    options: options,
                };

                bus.$emit('show-dialog', params);

                bus.$on('hide-dialog', () => {
                    resolve(); // console.log('resolved');
                });
            });
        },

        runToastr(message, title, type, options, hasMultiError) {
            return new Promise((resolve, reject) => {

                /* Display error message */
                if(!options.fade) {
                    this.removeFadeTimer();
                } else {
                    this.addFadeTimer();
                }

                /* Build options */
                let toastrOption = {
                    allowHtml: hasMultiError,
                    toastClass: 'toastr',
                    positionClass: "toast-top-center mt-2",
                    progressBar: true,
                    closeButton: true,
                    preventDuplicates: true,
                    onHidden: () => { 
                        resolve(); // console.log('resolved'); 
                    },
                    onclick: () => { 
                        resolve(); // console.log('resolved'); 
                    },
                    onCloseClick: () => { 
                        resolve(); // console.log('resolved'); 
                    },
                };

                /* Display notifications */
                switch(type) {
                    case 'error': toastr.error(message, title, toastrOption); break;
                    case 'warning': toastr.warning(message, title, toastrOption); break;
                    case 'success': toastr.success(message, title, toastrOption); break;
                    case 'info': toastr.info(message, title, toastrOption); break;
                }
            });
        },


        /**
         * Add in fade timer
         * 
         * @return integer
         */
        addFadeTimer(timer = 5000) {
            toastr.options.timeOut = timer;
        },

        /**
         * Remove in fade timer
         * 
         * @return integer
         */
        removeFadeTimer() {
            toastr.options.timeOut = 0;
        },        


        /**
         * ==================================================================================
         * @Checker
         * ==================================================================================
         **/

        /**
         * Check if field has error
         *
         * @return boolean
         **/
        hasError(field) {
            return field in this.errors;
        },

        /**
         * Check if errors is empty
         *
         * @return boolean
         **/
        hasEmptyErro() {
            return this.isEmpty(this.errors);
        },
    }
}