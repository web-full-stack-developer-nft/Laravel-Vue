<template>
<div>
	<div class="text-right">
		<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded" @click="$refs.modal.show()">
		  Create
		</button>
	</div> 
	<t-modal ref="modal">
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="storeOrUpdate" @keydown="form.onKeydown($event)">
            <div class="p-3">
                <h2 class="mb-2">{{ updateData ? 'Update' : 'Create' }} Project</h2>
                <div class="my-1" v-for="(value,name, index) in form.originalData" :key="index">
                    <p class="capitalize font-semibold"> {{ name }}</p>
                    <t-select 
                        v-if="name === 'client'"
                        v-model="form[name+'_id']"
                        :options="clients"
                        :class="{'is-invalid': form.errors.has(name)}"
                        class="w-full"/>

                    <t-input 
                        v-else 
                        v-model="form[name]" 
                        :class="{ 'is-invalid': form.errors.has(name) }" 
                        class="w-full"/>
                    <has-error :form="form" :field="name" class="mt-2 text-red-600 text-left font-semibold" />
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
        :url="base_url+'/api/projects'"
        :data="projects"
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
            url: base_url+'/api/projects',
            tableProps: {
                search: '',
                length: 10,
                column: 'id',
                dir: 'asc'
            },
            projects: {},
            updateData: false,
            isLoading: false,
            form: new Form({
                name: '',
                id: '',
                client_id: {},
            }),
            clients: [],
            columns: [
                {
                    label: 'ID',
                    name: 'id',
                    orderable: true,
                },
                {
                    label: 'Name',
                    name: 'name',
                    orderable: true,
                },
                {
                    label: 'Client',
                    name: 'client.name',
                    columnName: 'client.name',
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
                const response = await this.form.put('/api/projects/'+this.form.id);
                if (response.status === 200) {
                    this.cleanForm();
                    showMessage(response.status, 'Project updated successfully');
                }
            }else {
                const response = await this.form.post('/api/projects');
                if (response.status === 200) {
                    this.cleanForm();
                    showMessage(response.status, 'Project created successfully');
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
        async displayRow(data) {
            this.updateData = true;
            this.$refs.modal.show();
            this.form.name = data.name;
            this.form.id = data.id;
            this.form.client_id = data.client_id;
        },
        async getData(url = this.url, options = this.tableProps) {
            const response = await axios.get(url, {
                params: options
            });
            if(response.status === 200) {
                this.projects = response.data;
            }
        }
    },
    created(){
        var self = this;
        axios.get('/api/projects/create').then(function (response) {
            self.form.originalData=response.data;
        }).catch(function (error) {
            console.log(error);
        }).then(function () {
            // always executed
        });
    },
    mounted() {
        this.fetchClients();
    },
}
</script>