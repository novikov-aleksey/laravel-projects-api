import Errors from './Errors';

class Form
{
    constructor(data)
    {
        this.originalData = data;

        for (let field in data) {
            this[field] = data[field];
        }

        this.errors = new Errors();
    }

    reset()
    {
        for (let field in this.originalData) {
            this[field] = '';
        }
    }

    getData()
    {
        let data = Object.assign({}, this);

        delete data.originalData;
        delete data.errors;

        return data;
    }
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

    onSuccess(data)
    {
        this.reset();
    }

    onFail(data)
    {
        this.errors.store(data.errors);
    }
}

export default Form;
