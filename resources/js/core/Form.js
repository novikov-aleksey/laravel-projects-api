import Errors from './Errors';

/**
 * Form handling component
 */
class Form
{
    /**
     *
     * @param {object} data Form input which you want ot handle via current class
     */
    constructor(data)
    {
        this.originalData = data;

        for (let field in data) {
            this[field] = data[field];
        }

        this.errors = new Errors();
    }

    /**
     * Reset all input values
     */
    reset()
    {
        for (let field in this.originalData) {
            this[field] = '';
        }
    }

    /**
     * Get all input values
     *
     * @returns {object}
     */
    getData()
    {
        let data = Object.assign({}, this);

        delete data.originalData;
        delete data.errors;

        return data;
    }

    /**
     * Send request to providen endpoint
     *
     * @param {string} type      Type of request: get, post, put, delete
     * @param {string} endpoint Request handling endpoint
     *
     * @returns {Promise<any>}
     */
    request(type, endpoint)
    {
        return new Promise((resolve, reject) => {
            axios[type](endpoint, this.getData()).then(response => {
                this.onSuccess(response.data);

                resolve(response.data);
            }).catch(error => {
                this.onFail(error.response.data);

                reject(error.response.data);
            });
        });
    }

    /**
     * Event firing after success request
     *
     * @param {object} data Response data
     */
    onSuccess(data)
    {
        this.reset();
    }

    /**
     * Event firing if request failed
     *
     * @param {object} data Response data
     */
    onFail(data)
    {
        this.errors.store(data.errors);
    }
}

export default Form;
