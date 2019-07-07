class Errors
{
    constructor()
    {
        this.errors = {};
    }

    get(fieldName)
    {
        if (this.errors[fieldName]) {
            return this.errors[fieldName][0];
        }
    }

    store(errors)
    {
        this.errors = errors;
    }

    clear(field)
    {
        console.log(this.errors[field]);
        delete this.errors[field];
    }

    has(field)
    {
        return this.errors.hasOwnProperty(field);
    }

}

export default Errors;
