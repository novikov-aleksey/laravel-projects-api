<template>
    <div>
        <div class="jumbotron">
            <div class="container">
                <div class="col-md-7 offset-2">
                    <h1 class="display-3">Add a new User</h1>
                    <div>
                        <form method="post" action="/api/users" @submit.prevent="onSubmit"
                              @keydown="form.errors.clear($event.target.name)">
                            <div class="form-group">
                                <label for="first_name" class="label">First name: </label>
                                <input type="text" id="first_name" name="first_name" class="input form-control" v-model="form.first_name">
                                <div class="invalid-feedback" v-if="form.errors.has('first_name')" v-text="form.errors.get('first_name')"></div>
                            </div>

                            <div class="form-group">
                                <label for="last_name" class="label">Last name: </label>
                                <input type="text" id="last_name" name="last_name" class="input form-control" v-model="form.last_name">
                                <div class="invalid-feedback" v-if="form.errors.has('last_name')" v-text="form.errors.get('last_name')"></div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="label">Email: </label>
                                <input type="text" id="email" name="email" class="input form-control" v-model="form.email">
                                <div class="invalid-feedback" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="label">Password: </label>
                                <input type="password" id="password" name="password" class="input form-control" v-model="form.password">
                                <div class="invalid-feedback" v-if="form.errors.has('password')" v-text="form.errors.get('password')"></div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="button btn btn-primary">Create Project</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-3" v-for="user in users">

                    <div class="card" style="margin-bottom: 20px">
                        <div class="card-body">
                            <h5 class="card-title">{{user.first_name}} {{user.last_name}} </h5>
                            <div class="card-text">
                                {{user.email}}
                            </div>
                        </div>
                        <div class="card-body">
                            <a href="javascript:void(0)" class="card-link" @click="deleteUser(user.id)">Delete User</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Form from '../core/Form';

    export default {
        data()
        {
            return {
                users: [],
                form: new Form({
                    first_name: '',
                    last_name: '',
                    email: '',
                    password: ''
                })
            }
        },
        mounted()
        {
            axios.get('/api/users').then(response => this.users = response.data.data);
        },
        methods: {
            onSubmit()
            {
                this.form.request('post', '/api/users').then(response => {
                    this.users.unshift(response.data);
                }).catch(errors => {

                });
            },
            deleteUser(userID)
            {
                let deleteUri = '/api/users/' + userID;
                axios.delete(deleteUri).then(response => {
                    let removedUser = response.data.data;

                    for (let user in this.users) {
                        if (this.users[user].id === removedUser.id) {
                            this.users.splice(user, 1);
                        }
                    }
                });
            }
        }
    };
</script>
