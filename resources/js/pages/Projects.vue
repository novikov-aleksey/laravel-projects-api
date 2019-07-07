<template>
    <div>
        <div class="jumbotron">
            <div class="container">
                <div class="col-md-7 offset-2">
                    <h1 class="display-3">Add a new Project</h1>
                    <div>
                        <form method="post" action="/api/project" @submit.prevent="onSubmit"
                              @keydown="form.errors.clear($event.target.name)">
                            <div class="form-group">
                                <label for="name" class="label">Project name: </label>
                                <input type="text" id="name" name="name" class="input form-control" v-model="form.name">
                                <div class="invalid-feedback" v-if="form.errors.has('name')"
                                     v-text="form.errors.get('name')"></div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="label">Project description: </label>
                                <textarea id="description" class="input form-control" name="description"
                                          v-model="form.description"></textarea>
                                <div class="invalid-feedback" v-if="form.errors.has('description')"
                                     v-text="form.errors.get('description')"></div>
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
                <div class="col-md-3" v-for="project in projects">

                    <div class="card" style="margin-bottom: 20px">
                        <div class="card-body">
                            <h5 class="card-title">{{ project.name }}</h5>
                            <p class="card-text">
                                {{ project.description }}
                            </p>
                        </div>
                        <div class="card-body">
                            <a href="javascript:void(0);" class="card-link" @click="deleteProject(project.id)">Delete Projects</a>
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
                projects: [],
                form: new Form({
                    name: '',
                    description: ''
                })
            };
        },
        mounted()
        {
            axios.get('/api/projects').then(response => this.projects = response.data.data);
        },
        methods: {
            onSubmit()
            {
                this.form.request('post', '/api/projects').then(response => {
                    this.projects.unshift(response.data);
                }).catch(errors => {

                });
            },
            deleteProject(projectID)
            {
                let deleteUri = '/api/projects/' + projectID;
                axios.delete(deleteUri).then(response => {
                    let removedProject = response.data.data;

                    for (let project in this.projects) {
                        if (this.projects[project].id === removedProject.id) {
                            this.projects.splice(project, 1);
                        }
                    }
                });
            }
        }
    };
</script>
