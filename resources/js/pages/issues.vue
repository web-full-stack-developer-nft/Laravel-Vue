<template>
<div class="flex">
	<div class="w-1/2 p-3 bg-white">
		<div class="flex">
			<div class="w-1/2 py-2 pr-2">
				<multiselect 
				:disabled="project ? true : false"
				v-model="value" 
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
				      <div class="multiselect__clear absolute " v-if="value" @mousedown.prevent.stop="clearAll(props.search)">❌</div>
				    </template>
				</multiselect>
			</div>

			<div class="w-1/2 py-2 pl-2">
				<multiselect 
				v-model="project" 
				:disabled="value ? true : false"
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
				      <div class="multiselect__clear absolute " v-if="project" @mousedown.prevent.stop="clearAllProject(props.search)">❌</div>
				    </template>
				</multiselect>
			</div>
		</div>
		<div>
			<label class="block text-gray-700 text-sm font-bold mb-2" for="username">
		        Title *
		    </label>
			<input type="text" class="w-full t-input t-input-size-default t-input-status-default border block rounded p-2 bg-white" placeholder="Title">
		</div>
		<div>
	      	<label class="block text-gray-700 text-sm font-bold mb-2" for="grid-state">
	        	Type *
	      	</label>
		    <div class="relative">
		        <select class="block appearance-none w-full border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight" id="grid-state">
		          <option v-for="type in issue_types">{{ type.name }}</option>
		        </select>
		        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
		          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
		        </div>
		    </div>
	    </div>
	    <div>
	    	<label class="block text-gray-700 text-sm font-bold mb-2" for="grid-state">
	        	Details *
	      	</label>
			<textarea type="text" class="w-full t-input t-input-size-default t-input-status-default border block rounded p-2 bg-white" placeholder="Details">
			</textarea>
	    </div>
	    <div>
	    	<label class="block text-gray-700 text-sm font-bold mb-2" for="grid-state">
	        	Person *
	      	</label>
	    	<multiselect 
				v-model="user" 
				:options="users" 
				:hide-selected="true"
				:searchable="true"
				label="name"
				track-by="name"
				:multiple="true"
				placeholder="Search Project"
				>
					<template slot="clear" slot-scope="props">
				      <div class="multiselect__clear absolute " v-if="project" @mousedown.prevent.stop="clearAllProject(props.search)">❌</div>
				    </template>
				</multiselect>
	    </div>
	    <div class="text-right mt-2">
	    	<v-button :loading="form.busy">
				Submit
			</v-button>
	    </div>
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
	    value: null,
	    options: [],
	    isLoading: false,
	    issues:[],
	    isLoadingproject:false,
	    project:null,
	    projects:[],
	    issue_types:[],
	    user:[],
	    users:[],
      	form: new Form({
			email: '',
			password: ''
		}),
    }
  },
  methods: {
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
      this.value = null
    },
    clearAllProject () {
      this.project = null
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

