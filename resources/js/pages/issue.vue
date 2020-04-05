<template>
<div>
	<div class="text-right">
		<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded" @click="$refs.modal.show()">
		  Create
		</button>
	</div> 
	<t-modal ref="modal" class="curdmodel">
        <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="storeOrUpdate" @keydown="form.onKeydown($event)">
            <div class="p-3">
                <h2 class="mb-2">{{ updateData ? 'Update' : 'Create' }} Issue</h2>
                <div class="my-1" v-for="(value,name, index) in form.originalData" :key="index">

                    <div class="mb-4" v-if="name === 'title'">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Title
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" v-model="form[name]" type="text" placeholder="Issue Title">
                        <has-error :form="form" :field="name" class="mt-2 text-red-600 text-left font-semibold" />
                    </div>

                    <div class="mb-4" v-if="name === 'desc'">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Description
                        </label>
                        <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" v-model="form[name]" rows="3" placeholder="Issue Description"></textarea>
                        <has-error :form="form" :field="name" class="mt-2 text-red-600 text-left font-semibold" />
                    </div>

                    <div class="mb-4" v-if="name === 'client'">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Client
                        </label>
                        <t-select 
                            v-if="name === 'client'"
                            v-model="form[name+'_id']"
                            :disabled="form.project_id === '' || form.project_id === null ? false : true"
                            :options="clients"
                            :class="{'is-invalid': form.errors.has(name)}"
                            class="w-full"/>
                    </div>

                    <div class="mb-4" v-if="name === 'project'">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Project
                        </label>
                        <t-select 
                            v-if="name === 'project'"
                            v-model="form[name+'_id']"
                            :disabled="form.client_id === '' || form.client_id === null ? false : true"
                            :options="projects"
                            :class="{'is-invalid': form.errors.has(name)}"
                            class="w-full"/>
                    </div>

                    <div class="mb-4" v-if="name === 'department'">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Department
                        </label>
                        <t-select 
                            v-if="name === 'department'"
                            v-model="form[name+'_id']"
                            :options="departments"
                            :class="{'is-invalid': form.errors.has(name)}"
                            class="w-full"/>
                        <has-error :form="form" :field="'department_id'" class="mt-2 text-red-600 text-left font-semibold" />
                    </div>

                    <div class="mb-4" v-if="name === 'issue_type'">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Type
                        </label>
                        <t-select 
                            v-if="name === 'issue_type'"
                            v-model="form[name+'_id']"
                            :options="issue_types"
                            :class="{'is-invalid': form.errors.has(name)}"
                            class="w-full"/>
                        <has-error :form="form" :field="'issue_type_id'" class="mt-2 text-red-600 text-left font-semibold" />
                    </div>
                </div>
                <div class="mt-3 text-right">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" :loading="form.busy">
                      {{ updateData ? 'Update' : 'Create' }}
                    </button>
                </div>
            </div>
        </form>
    </t-modal>
	<data-table
        :columns="columns"
        :classes="classes"
        :responsive="true"
        :responsive-breakpoint="1024"
        :url="base_url+'/api/issues'"
        :data="issues"
        @loading="isLoading = true"
        @finishedLoading="isLoading = false">
    </data-table>
    <loading
        :is-full-page="true"
        :active.sync="isLoading">
    </loading>
</div>
</template>

<script>
import Loading from 'vue-loading-overlay';
import EditButon from '../buttons/EditButton.vue';
import Form from 'vform';
import axios from 'axios';
export default {
    middleware: 'auth',
    components: {
        EditButon,
        Loading,
    },
	data() {
        return {
            base_url: base_url,
            url: base_url+'/api/issues',
            tableProps: {
                search: '',
                length: 10,
                column: 'id',
                dir: 'asc'
            },
            issues: {},
            updateData: false,
            isLoading: false,
            form: new Form({
                name: '',
                id: '',
                client_id: '',
                project_id: '',
                department_id: '',
                issue_type_id: '',
                desc: ''
            }),
            clients: [],
            projects: [],
            departments: [],
            issue_types: [],
            statuses: [],
            columns: [
                {
                    label: 'ID',
                    name: 'id',
                    orderable: true,
                },
                {
                    label: 'Issue',
                    name: 'title',
                    orderable: true,
                },
                {
                    label: 'Project',
                    name: 'project.name',
                    columnName: 'projects.name',
                    orderable: true,
                },
                {
                    label: 'Client',
                    name: 'client.name',
                    columnName: 'clients.name',
                    orderable: true,
                },
                {
                    label: 'Department',
                    name: 'department.name',
                    columnName: 'departments.name',
                    orderable: true,
                },
                {
                    label: 'Type',
                    name: 'issue_type.name',
                    columnName: 'issue_type.name',
                    orderable: true,
                },
                {
                    label: 'Status',
                    name: 'status.name',
                    columnName: 'statuses.name',
                    orderable: true,
                },
                {
                    label: 'Date',
                    name: 'created_at',
                    columnName: 'created_at',
                    orderable: true,
                },
                {
                    label: '',
                    name: 'Edit',
                    orderable: false,
                    classes: {
                        'btn': true,
                        'btn-blue': true,
                        'bg-blue-500': true,
                        'hover:bg-blue-700': true,
                        'py-2': true,
                        'text-white': true,
                        'font-bold': true,
                        'px-4': true,
                        'rounded': true,
                        'float-right': true
                    },
                    event: 'click',
                    handler: this.displayRow,
                    component: EditButon
                },
            ],
            classes: { 
                'table-container': {
                    'justify-center': true,
                    'w-full': true,
                    'flex': true,
                    "border-gray-200": true,
                    'inline-block': true,
                    'min-w-full': true,
                    'rounded-lg': true,
                    'overflow-hidden': true,
                },
                table: {
                    'text-left': true,
                    'w-full': true,
                },
                "t-body": {
                    'bg-white': true,
                },
                "t-head-tr": {
                    'border-b': true,
                    'border-gray': true,
                },
                "t-body-tr": {
                    'stripped-table': true,
                    'bg-grey-darkest': true,
                },
                "td": {
                    'py-4': true,
                    'px-6': true,
                    'border-b': true,
                    'border-grey-light': true,
                    'text-gray-light': true,
                },
                "th": {
                    'text-gray-dark': true,
                    'border-gray': true,
                    'border-b-2': true,
                    'border-t-2': true,
                    'border-gray-200': true,
                    'py-3': true,
                    'px-4': true,
                    'bg-gray-100': true,
                    'text-left': true,
                    'text-xs': true,
                    'font-semibold': true,
                    'text-gray-600': true,
                    'uppercase': true,
                    'tracking-wider': true,
                },
            },
            column:[]
        }
    },
    methods:{
        cleanForm() {
            this.$refs.modal.hide();
            this.getData(this.url);
            this.updateData = false;
            this.form.name = '';
            this.form.id = '';
            this.form.client_id = '';
            this.errors = {};
        },
    	async storeOrUpdate () {
            // Submit the form.
            if(this.updateData) {
                const response = await this.form.put('/api/issues/'+this.form.id);
                if (response.status === 200) {
                    this.cleanForm();
                    showMessage(response.status, 'Issue updated successfully');
                }
            }else {
                const response = await this.form.post('/api/issues');
                if (response.status === 200) {
                    this.cleanForm();
                    showMessage(response.status, 'Issue created successfully');
                }
            }
        },
        async fetchClients() {
            const response = await axios.get('/api/clients/all', {status: 1});
            if (response.status === 200) {
                this.clients = await response.data.map((client) => {
                    return {
                        value: client.id,
                        text: client.name
                    }
                });
            }
        },
        async fetchProjects() {
            const response = await axios.get('/api/projects/all', {status: 1});
            if (response.status === 200) {
                this.projects = await response.data.map((project) => {
                    return {
                        value: project.id,
                        text: project.name
                    }
                });
            }
        },
        async fetchDepartments() {
            const response = await axios.get('/api/departments/all', {status: 1});
            if (response.status === 200) {
                this.departments = await response.data.map((department) => {
                    return {
                        value: department.id,
                        text: department.name
                    }
                });
            }
        },
        async fetchIssueTypes() {
            const response = await axios.get('/api/issue_types/all', {status: 1});
            if (response.status === 200) {
                this.issue_types = await response.data.map((issue_type) => {
                    return {
                        value: issue_type.id,
                        text: issue_type.name
                    }
                });
            }
        },
        async fetchStatuses() {
            const response = await axios.get('/api/statuses/all', {status: 1});
            if (response.status === 200) {
                this.statuses = await response.data.map((status) => {
                    return {
                        value: status.id,
                        text: status.name
                    }
                });
            }
        },
        async displayRow(data) {
            this.updateData = true;
            this.$refs.modal.show();
            this.form.title = data.title;
            this.form.desc = data.desc;
            this.form.id = data.id;
            this.form.client_id = data.client_id;
            this.form.project_id = data.project_id;
            this.form.department_id = data.department_id;
            this.form.issue_type_id = data.issue_type_id;
            this.form.status_id = data.status_id;
        },
        async getData(url = this.url, options = this.tableProps) {
            const response = await axios.get(url, {
                params: options
            });
            if(response.status === 200) {
                this.issues = response.data;
            }
        }
    },
    created(){
        var self = this;
        axios.get('/api/issues/create').then(function (response) {
            self.form.originalData=response.data;
        }).catch(function (error) {
            console.log(error);
        }).then(function () {
            // always executed
        });
    },
    mounted() {
        this.fetchClients();
        this.fetchProjects();
        this.fetchDepartments();
        this.fetchIssueTypes();
        this.fetchStatuses();
    },
}
</script>