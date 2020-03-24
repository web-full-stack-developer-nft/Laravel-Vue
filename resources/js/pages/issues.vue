<template>
<div class="flex">
	<div class="w-1/2 p-3 bg-white">
		<form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="create" @keydown="form.onKeydown($event)">
			<div class="flex">
				<div class="w-1/2 py-2 pr-2">
					<multiselect 
					:disabled="form.project ? true : false"
					v-model="form.value" 
					:options="options" 
					@search-change="asyncFind" 
					@select="fatchissue" 
					:loading="isLoading"
					:hide-selected="true"
					:searchable="true"
					label="name"
					track-by="name"
					placeholder="Search Client"
					>
						<template slot="clear" slot-scope="props">
					      <div class="multiselect__clear absolute " v-if="form.value" @mousedown.prevent.stop="clearAll(props.search)">❌</div>
					    </template>
					</multiselect>
					<has-error :form="form" field="value" class="mt-2 text-red-600 text-left font-semibold" />
				</div>

				<div class="w-1/2 py-2 pl-2">
					<multiselect 
					v-model="form.project" 
					:disabled="form.value ? true : false"
					:options="projects" 
					@search-change="projectFind" 
					@select="fatchproject" 
					:loading="isLoadingproject"
					:hide-selected="true"
					:searchable="true"
					label="name"
					track-by="name"
					placeholder="Search Project"
					>
						<template slot="clear" slot-scope="props">
					      <div class="multiselect__clear absolute " v-if="form.project" @mousedown.prevent.stop="clearAllProject(props.search)">❌</div>
					    </template>
					</multiselect>
					<has-error :form="form" field="project" class="mt-2 text-red-600 text-left font-semibold" />
				</div>
			</div>
			<div>
				<label class="block text-gray-700 text-sm font-bold mb-2" for="username">
			        Title *
			    </label>
				<input v-model="form.title" class="w-full t-input t-input-size-default t-input-status-default border block rounded p-2 bg-white" placeholder="Title">
				<has-error :form="form" field="title" class="mt-2 text-red-600 text-left font-semibold" />
			</div>
			<div>
		      	<label class="block text-gray-700 text-sm font-bold mb-2" for="grid-state">
		        	Type *
		      	</label>
			    <div class="relative">
			        <select v-model="form.issue_type_id" class="block appearance-none w-full border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight" id="grid-state">
			          <option v-for="type in issue_types">{{ type.name }}</option>
			        </select>
			        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
			          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
			        </div>
			    </div>
			    <has-error :form="form" field="issue_type_id" class="mt-2 text-red-600 text-left font-semibold" />
		    </div>
		    <div>
		    	<label class="block text-gray-700 text-sm font-bold mb-2" for="grid-state">
		        	Details *
		      	</label>
				<textarea v-model="form.desc" type="text" class="w-full t-input t-input-size-default t-input-status-default border block rounded p-2 bg-white" placeholder="Details">
				</textarea>
			    <has-error :form="form" field="desc" class="mt-2 text-red-600 text-left font-semibold" />
		    </div>
		    <div>
		    	<label class="block text-gray-700 text-sm font-bold mb-2" for="grid-state">
		        	Person *
		      	</label>
		    	<multiselect 
					v-model="form.user" 
					:options="users" 
					:hide-selected="true"
					:searchable="true"
					label="name"
					track-by="name"
					:multiple="true"
					placeholder="Search Project"
					>
						
					</multiselect>
					<has-error :form="form" field="user" class="mt-2 text-red-600 text-left font-semibold" />
		    </div>
		    <div class="text-right mt-2">
		    	<v-button :loading="form.busy">
					Submit
				</v-button>
		    </div>
		</form>
	</div>
	<div class="w-1/2 p-3">
		<h2 class="font-bold bg-gray-600 p-2">Issue Lists</h2>
		<table class="w-full bg-white" v-if="issues">
		   <tbody>
		   		<tr>
		   			<th class="p-2 border border-gray-200 text-sm text-left">NO</th>
		   			<th class="p-2 border border-gray-200 text-sm text-left">Status</th>
		   			<th class="p-2 border border-gray-200 text-sm text-left">Creation</th>
		   			<th class="p-2 border border-gray-200 text-sm text-left">Issue Title</th>
		   			<th class="p-2 border border-gray-200 text-sm text-left">Issue Details</th>
		   		</tr>
                <tr v-for="issue in issues">
                    <td class="p-2 border border-gray-200 text-sm">
                        Admin
                    </td>
                    <td class="p-2 border border-gray-200 text-sm">
                        Admin
                    </td>
                    <td class="p-2 border border-gray-200 text-sm">
                        Admin
                    </td>
                    <td class="p-2 border border-gray-200 text-sm">
                        Admin
                    </td>
                    <td class="p-2 border border-gray-200 text-sm">
                        Admin
                    </td>
                </tr>
            </tbody>
        </table>
	</div>
</div>
</template>

<script>
import Form from 'vform'
import axios from 'axios'
export default {
  middleware: 'auth',
  data () {
    return {
	    options: [],
	    isLoading: false,
	    issues:[],
	    isLoadingproject:false,
	    projects:[],
	    issue_types:[],
	    users:[],
      	form: new Form({
	    	value: null,
	    	project:null,
	    	user:[],
	    	title:'',
	    	issue_type_id:'',
	    	details:''
		}),
    }
  },
  methods: {
  	async create (){
		const { data } = await this.form.post('api/issues')
		console.log(data);
  	},
    async asyncFind(query){
    	var self = this;
    	if(query.length>0){
	    	this.isLoading = true
	    	let res = await axios.get('api/clientsearch/'+query)
	    	this.options = res.data
	    	this.isLoading = false
    	}
    },
    clearAll () {
      this.form.value = null
    },
    clearAllProject () {
      this.form.project = null
    },
    async projectFind(query){
    	var self = this;
    	if(query.length>0){
	    	this.isLoadingproject = true
	    	let res = await axios.get('api/projectsearch/'+query)
	    	this.projects = res.data
	    	this.isLoadingproject = false
    	}
    },
    async fatchissue(client){
	    let res = await axios.get('api/issueforslient/'+client.id)
	    this.issues=res.data;
    },
    async fatchproject(project){
	    let res = await axios.get('api/issueforprojectsearch/'+project.id)
	    this.issues=res.data;
    }
  },
  async created(){
	    let res = await axios.get('api/users/')
	    this.users = res.data
	    let issue_types = await axios.get('api/issue_types/all/')
	    this.issue_types=issue_types.data
  }
}
</script>

<style>
	.multiselect__clear{
		position: absolute;
	    right: 27px;
	    top: 7px;
	    z-index: 5;
	    cursor: pointer;
	}
</style>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

