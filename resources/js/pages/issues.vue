<template>
<div class="md:flex">
	<div class="flex-initial w-full m-2 bg-white shadow-md">
		<form class="bg-white rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="create" @keydown="form.onKeydown($event)">
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
				<label class="block text-gray-700 text-sm font-bold my-2 uppercase" for="username">
			        Title <span class="text-red-600">*</span>
			    </label>
				<input v-model="form.title" class="w-full t-input t-input-size-default t-input-status-default border block rounded p-2 bg-white" placeholder="Title">
				<has-error :form="form" field="title" class="mt-2 text-red-600 text-left font-semibold" />
			</div>
			<div>
		      	<label class="block text-gray-700 text-sm font-bold my-2 uppercase" for="grid-state">
		        	Type <span class="text-red-600">*</span>
		      	</label>
			    <div class="relative">
			        <select v-model="form.issue_type_id" class="block appearance-none w-full border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight" id="grid-state">
			          <option :value="type.id" v-for="type in issue_types">{{ type.name }}</option>
			        </select>
			        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
			          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
			        </div>
			    </div>
			    <has-error :form="form" field="issue_type_id" class="mt-2 text-red-600 text-left font-semibold" />
		    </div>
		    <div>
		    	<label class="block text-gray-700 text-sm font-bold my-2 uppercase" for="grid-state">
		        	Details <span class="text-red-600">*</span>
		      	</label>
				<textarea v-model="form.desc" type="text" class="w-full t-input t-input-size-default t-input-status-default border block rounded p-2 bg-white" placeholder="Details">
				</textarea>
			    <has-error :form="form" field="desc" class="mt-2 text-red-600 text-left font-semibold" />
		    </div>
		    <div>
		    	<label class="block text-gray-700 text-sm font-bold my-2 uppercase" for="grid-state">
		        	Person <span class="text-red-600">*</span>
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

	<div class="flex-initial w-full m-2 shadow-md bg-white">
		<h2 class="font-bold bg-blue-700 p-2 text-white">Issue Lists</h2>
		<vue-scroll>
			<div class="h-0">
				<table class="w-full bg-white" v-if="issues">
				   <tbody>
				   		<tr>
				   			<th class="p-1 border border-gray-200 text-sm text-left">NO</th>
				   			<th class="p-1 border border-gray-200 text-sm text-left">Status</th>
				   			<th class="p-1 border border-gray-200 text-sm text-left">Creation</th>
				   			<th class="p-1 border border-gray-200 text-sm text-left">Issue Title</th>
				   			<th class="p-1 border border-gray-200 text-sm text-left">Issue Details</th>
				   		</tr>
		                <tr v-for="(issue,index) in issues.slice().reverse()" @click="fatchdata(issue.id)" class="cursor-pointer">
		                    <td class="p-1 border border-gray-200 text-sm">
		                        {{ index+1 }}
		                    </td>
		                    <td class="p-1 border border-gray-200 text-sm">
		                        <span class="bg-gray-500 text-white p-1 capitalize rounded" v-if="statuss(issue.status_id)=='Pending'">
		                        	{{ statuss(issue.status_id) }}
		                    	</span>
		                        <span class="bg-gray-600 text-white p-1 capitalize rounded" v-if="statuss(issue.status_id)=='In Progress'">
		                        	{{ statuss(issue.status_id) }}
		                    	</span>
		                        <span class="bg-gray-700 text-white p-1 capitalize rounded" v-if="statuss(issue.status_id)=='Pause'">
		                        	{{ statuss(issue.status_id) }}
		                        </span>
		                        <span class="bg-gray-800 text-white p-1 capitalize rounded" v-if="statuss(issue.status_id)=='Stop'">
		                        	{{ statuss(issue.status_id) }}
		                        </span>
		                        <span class="bg-indigo-500 text-white p-1 capitalize rounded" v-if="statuss(issue.status_id)=='Done'">
		                        	{{ statuss(issue.status_id) }}
		                        </span>
		                        <span class="bg-indigo-600 text-white p-1 capitalize rounded" v-if="statuss(issue.status_id)=='Checked'">
		                        	{{ statuss(issue.status_id) }}
		                        </span>
		                        <span class="bg-indigo-700 text-white p-1 capitalize rounded" v-if="statuss(issue.status_id)=='Completed'">
		                        	{{ statuss(issue.status_id) }}
		                        </span>
		                    </td>
		                    <td class="p-1 border border-gray-200 text-sm">
		                        {{ issue.created_at }}
		                    </td>
		                    <td class="p-1 border border-gray-200 text-sm">
		                        {{ issue.title }}
		                    </td>
		                    <td class="p-1 border border-gray-200 text-sm">
		                        {{ issue.desc }}
		                    </td>
		                </tr>
		            </tbody>
		        </table>
	        </div>
    	</vue-scroll>
	</div>
	<t-modal ref="modal" class="curdmodel">
	   	<p class="text-xl font-bold uppercase" v-if="singleissue.client">Client: {{ singleissue.client.name }}</p>
	   	<hr>
      	<h2 class="text-indigo-500">
		  <div class="dropdown inline-block relative">
		    <svg class="fill-current h-4 w-4 inline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/> </svg>{{ singleissue.title }}
		    <ul class="dropdown-menu absolute hidden text-gray-700 pt-1">
		      <li class="" v-for="st in status" @click="statusupdate(st.id)">
		      	<a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap" href="#">{{ st.name }}</a>
		      </li>
		    </ul>
		  </div>
		</h2>
	    <p v-if="singleissue.issue_type"> Type : {{ singleissue.issue_type.name }}</p>
	    <p v-if="singleissue.status">Status : {{ singleissue.status.name }}</p>
	    <p v-if="singleissue.creator">Creator : {{ singleissue.creator.name }}</p>
	    <p>Created:  {{ singleissue.created_at }}</p>
	    <label-edit 
	    	:text="singleissue.desc"
	    	id="labeledit1"
	    	v-on:text-updated="textUpdated">
	    </label-edit>
      	<br>
      	
		<form class="bg-white rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="createcommment">
	        <div>
	        
				<textarea v-model="comment" v-on:keyup="createcommment" type="text" class="w-full t-input t-input-size-default t-input-status-default border block rounded p-2 bg-white" placeholder="Comment">
				</textarea>
		    </div>
		</form>
	
		<div v-if="singleissue.comments">
			<div  v-for="comment in reverseItems" class="p-2">
				<div class="flex">
					<div>
						<avatar :username="comment.user.name" backgroundColor="#7F9CF5"></avatar>
					</div>
					<div class="pl-2">
						<p><span class="font-bold">{{ comment.user.name }}</span> <span>{{ comment.created_at }}</span></p>
						<p class="bg-white shadow p-2 bg-gray-100">{{ comment.comment }}</p>
					</div>
				</div>
			</div>
		</div>
    </t-modal>

</div>
</template>

<script>
import Form from 'vform'
import axios from 'axios'
import { mapGetters } from 'vuex'
import LabelEdit from 'label-edit'
export default {
  	middleware: 'auth',
  	components: {
	    LabelEdit,
	},
    data () {
    	return {
		    options: [],
		    isLoading: false,
		    issues:[],
		    isLoadingproject:false,
		    projects:[],
		    status:[],
		    issue_types:[],
		    users:[],
		    singleissue:[],
	      	form: new Form({
		    	value: null,
		    	project:null,
		    	user:[],
		    	title:'',
		    	issue_type_id:'',
		    	details:''
			}),
			comment:'',
    	}
 	},
  	computed:{ 
  		...mapGetters({
			authuser: 'auth/user'
		}),
		reverseItems() {
        	return this.singleissue.comments.slice().reverse();
  		},
  	},
  	methods: {
	  	textUpdated: function(text){
	    	this.singleissue.desc = text;
	    },
		statuss(id){
			var abc =''
			this.status.forEach((item)=>{
				if(item.id==id){
					abc=item.name;
				}
			})
			return abc; 
		},
	  	async statusupdate(id){
	  		let con = confirm("Are You Sure Want To Change?");
	  		if(con){

	  			this.issues.find((item)=>{
	  				if(item.id==this.singleissue.id){
	  					item.status_id=id
	  				}
	  			})

	  			await axios.post('api/issues/statusupdate',{
													    issue_id: this.singleissue.id,
													    status_id: id,
													})
	  		}
	  	},
	  	async createcommment(e){
	  		if (e.keyCode === 13) {
	  			this.singleissue.comments.push({comment:this.comment,user:this.authuser});
				await axios.post('api/issuecomment',{
													    user_id: this.authuser.id,
													    issue_id: this.singleissue.id,
													    comment: this.comment,
													})
	  			this.comment=''
	  		}
	  	},
	  	async fatchdata(id){
			const { data } = await axios.get('api/issues/'+id)
			this.singleissue=data
			console.log(data);
	  		this.$refs.modal.show()
	  	},
	  	async create (){
			const { data } = await this.form.post('api/issues')
			this.issues.push(data.issue)
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

	    let status = await axios.get('api/statuses/all')
	    this.status=status.data
  	}
}
</script>

<style>
	.curdmodel .overflow-hidden{
		overflow-y: scroll;
	}
	.multiselect__clear{
		position: absolute;
	    right: 27px;
	    top: 7px;
	    z-index: 5;
	    cursor: pointer;
	}
</style>


