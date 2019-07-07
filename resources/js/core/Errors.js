/**
 * Forms errors handling class
 */
class Errors
{
    /**
     *
     */
    constructor()
    {
        /**
         * All errors of the form
         * @type {Object}
         */
        this.errors = {};
    }

    /**
     * Get error from the list by input name
     *
     * @param {String} fieldName
     * @returns {*}
     */
    get(fieldName)
    {
        if (this.errors[fieldName]) {
            return this.errors[fieldName][0];
        }
    }

    /**
     * Save all errors
     *
     * @param errors
     */
    store(errors)
    {
        this.errors = errors;
    }

    /**
     * Remove some error from the list by input name
     *
     * @param {String} field
     */
    clear(field)
    {
        delete this.errors[field];
    }

    /**
     * Is error is exist for provided input name
     *
     * @param {string} field
     * @returns {boolean}
     */
    has(field)
    {
        return this.errors.hasOwnProperty(field);
    }

}

export default Errors;
