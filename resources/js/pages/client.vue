<template>
<div>
	<div class="text-right">
		<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded" @click="$refs.modal.show()">
		  Create
		</button>
	</div> 
	<t-modal ref="modal">
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="store" @keydown="form.onKeydown($event)">
            <div class="p-3">
                <h2 class="mb-2">Crate Client</h2>
                <div class="my-1" v-for="(value,name, index) in form.originalData">
                    <p class="capitalize font-semibold"> {{ name }}</p>
                    <t-input v-model="form[name]" :class="{ 'is-invalid': form.errors.has(name) }" class="w-full"/>
                    <has-error :form="form" :field="name" class="mt-2 text-red-600 text-left font-semibold" />
                </div>
                <div class="mt-3 text-right">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" :loading="form.busy">
                      Create
                    </button>
                </div>
            </div>
        </form>
    </t-modal>
	<data-table
        :columns="columns"
        :classes="classes"
        url="http://localhost:3000/api/clients">
    </data-table>
</div>
</template>

<script>
import Form from 'vform'
import axios from 'axios'
export default {
  	middleware: 'auth',
	data() {
        return {
            form: new Form({
                email: '',
                password: ''
            }),
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
                    label: 'Email',
                    name: 'email',
                    orderable: true,
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
    	async store () {
            // Submit the form.
            const { data } = await this.form.post('/api/clients')
        }
    },
    created(){
        var self = this;
        axios.get('/api/clients/create').then(function (response) {
            self.form.originalData=response.data;
        }).catch(function (error) {
            console.log(error);
        }).then(function () {
            // always executed
        });
    }
}
</script>