<template>
<div class="md:flex">
	<div class="flex-initial w-full p-3 bg-white">
		<form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="create" @keydown="form.onKeydown($event)">
			<div>
				<multiselect 
					v-model="form.issue_id" 
					:options="issues" 
					@search-change="asyncFind" 
					@select="fatchtask" 
					:loading="isLoading"
					:hide-selected="true"
					:searchable="true"
					label="title"
					track-by="title"
					placeholder="Search Issue"
				>
					<template slot="clear" slot-scope="props">
				      	<div class="multiselect__clear absolute " v-if="form.value" @mousedown.prevent.stop="clearAll(props.search)">❌</div>
				    </template>
				</multiselect>
				<has-error :form="form" field="value" class="mt-2 text-red-600 text-left font-semibold" />
			</div>
			<div>
				<label class="block text-gray-700 text-sm font-bold mb-2" for="username">
			        Title *
			    </label>
				<input v-model="form.name" class="w-full t-input t-input-size-default t-input-status-default border block rounded p-2 bg-white" placeholder="Title">
				<has-error :form="form" field="name" class="mt-2 text-red-600 text-left font-semibold" />
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
					v-model="form.user_id" 
					:options="users" 
					:hide-selected="true"
					:searchable="true"
					label="name"
					track-by="name"
					:multiple="false"
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

	<div class="flex-initial w-full p-3">
		<h2 class="font-bold bg-blue-700 p-2 text-white">Issue Lists</h2>
		<table class="w-full bg-white" v-if="tasks">
		   <tbody>
		   		<tr>
		   			<th class="p-2 border border-gray-200 text-sm text-left">NO</th>
		   			<th class="p-2 border border-gray-200 text-sm text-left">Status</th>
		   			<th class="p-2 border border-gray-200 text-sm text-left">Creation</th>
		   			<th class="p-2 border border-gray-200 text-sm text-left">Issue Title</th>
		   			<th class="p-2 border border-gray-200 text-sm text-left">Issue Details</th>
		   		</tr>
                <tr v-for="(task,index) in tasks.slice().reverse()" @click="fatchdata(task.id)" class="cursor-pointer">
                    <td class="p-2 border border-gray-200 text-sm">
                        {{ index+1 }}
                    </td>
                    <td class="p-2 border border-gray-200 text-sm">
                        <span class="bg-gray-500 text-white p-1 capitalize rounded" v-if="statuss(task.status_id)=='Pending'">
                        	{{ statuss(task.status_id) }}
                    	</span>
                        <span class="bg-gray-600 text-white p-1 capitalize rounded" v-if="statuss(task.status_id)=='In Progress'">
                        	{{ statuss(task.status_id) }}
                    	</span>
                        <span class="bg-gray-700 text-white p-1 capitalize rounded" v-if="statuss(task.status_id)=='Pause'">
                        	{{ statuss(task.status_id) }}
                        </span>
                        <span class="bg-gray-800 text-white p-1 capitalize rounded" v-if="statuss(task.status_id)=='Stop'">
                        	{{ statuss(task.status_id) }}
                        </span>
                        <span class="bg-indigo-500 text-white p-1 capitalize rounded" v-if="statuss(task.status_id)=='Done'">
                        	{{ statuss(task.status_id) }}
                        </span>
                        <span class="bg-indigo-600 text-white p-1 capitalize rounded" v-if="statuss(task.status_id)=='Checked'">
                        	{{ statuss(task.status_id) }}
                        </span>
                        <span class="bg-indigo-700 text-white p-1 capitalize rounded" v-if="statuss(task.status_id)=='Completed'">
                        	{{ statuss(task.status_id) }}
                        </span>
                    </td>
                    <td class="p-2 border border-gray-200 text-sm">
                        {{ task.created_at }}
                    </td>
                    <td class="p-2 border border-gray-200 text-sm">
                        {{ task.name }}
                    </td>
                    <td class="p-2 border border-gray-200 text-sm">
                        {{ task.desc }}
                    </td>
                </tr>
            </tbody>
        </table>
	</div>

	<t-modal ref="modal" class="curdmodel" v-if="singletask">
	   	<p>IT Lab Solutions Ltd</p>
	   	<hr>
      	<h2 class="text-indigo-500">
		  <div class="dropdown inline-block relative">
		    <svg class="fill-current h-4 w-4 inline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/> </svg>{{ singletask.title }}
		    <ul class="dropdown-menu absolute hidden text-gray-700 pt-1">
		      <li class="" v-for="st in status" @click="statusupdate(st.id)">
		      	<a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap" href="#">{{ st.name }}</a>
		      </li>
		    </ul>
		  </div>
		</h2>
	    <p v-if="singletask.issue_type"> Type : {{ singletask.issue_type.name }}</p>
	    <p v-if="singletask.status">Status : {{ singletask.status.name }}</p>
	    <p v-if="singletask.creator">Creator : {{ singletask.creator.name }}</p>
	    <p>Created:  {{ singletask.created_at }}</p>
	    <p>Details: {{ singletask.desc }}</p>
      	<br>
		<form class="bg-white rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="createcommment">
	        <div>
	        
				<textarea v-model="comment" v-on:keyup="createcommment" type="text" class="w-full t-input t-input-size-default t-input-status-default border block rounded p-2 bg-white" placeholder="Comment">
				</textarea>
		    </div>
		</form>
	
		<div v-if="singletask.comments">
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
export default {
  	middleware: 'auth',
    data () {
    	return {
		    isLoading: false,
		    issues:[],
		    isLoadingproject:false,
		    status:[],
		    users:[],
		    singletask:[],
		    tasks:[],
	      	form: new Form({
		    	issue_id: null,
		    	user_id:[],
		    	name:'',
		    	desc:''
			}),
			comment:'',
    	}
 	},
  	computed:{ 
  		...mapGetters({
			authuser: 'auth/user'
		}),
		reverseItems() {
        	return this.singletask.comments.slice().reverse();
  		},
  	},
  	methods: {
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
			await axios.post('api/comment',{
										    user_id: this.authuser.id,
										    task_id: this.singleissue.id,
										    comment: this.comment,
										})
  			this.comment=''
  		}
  	},
  	async fatchdata(id){
		const { data } = await axios.get('api/tasks/'+id)
		this.singletask=data
  		this.$refs.modal.show()
  	},
  	async create (){
		const { data } = await this.form.post('api/tasks')
		this.tasks.push(data)
  	},
    async asyncFind(query){
    	var self = this;
    	if(query.length>0){
	    	this.isLoading = true
	    	let res = await axios.get('api/issuesearch/'+query)
	    	this.issues = res.data
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
    async fatchtask(issue){
	    let res = await axios.get('api/taskforissue/'+issue.id)
	    this.tasks=res.data;
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


