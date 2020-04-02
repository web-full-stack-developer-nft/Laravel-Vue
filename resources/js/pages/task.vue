<template>
<vue-scroll>
	<div class="flex px-4 pb-8 items-start"> 
		<div v-for="statu in status" class="rounded shadow p-2 flex-no-shrink w-auto p-2 mr-3"  style="min-width: 293px!important;">
			<div class="flex justify-between py-1">
                <h3 class="text-sm">{{ statu.name }}</h3>
                <svg class="h-4 fill-current text-grey-dark cursor-pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M5 10a1.999 1.999 0 1 0 0 4 1.999 1.999 0 1 0 0-4zm7 0a1.999 1.999 0 1 0 0 4 1.999 1.999 0 1 0 0-4zm7 0a1.999 1.999 0 1 0 0 4 1.999 1.999 0 1 0 0-4z"></path></svg>
            </div>
			<vue-scroll>
				<div class="fixed-height">
					<draggable class="list-group" :list="statu.tasks" group="statu.tasks" @add="add(statu.id)" @change="log">
						<div
							class="bg-white p-2 rounded mt-1 border-b border-grey cursor-pointer hover:bg-grey-lighter"
							v-for="(task, index) in statu.tasks"
							:key="task.id"
							@click="fetchstatus(task.id)"
						>
							{{ task.name }}
						</div>
					</draggable>
				</div>
			</vue-scroll>
			<div v-if="isadd==statu.id">
				<textarea name="" id="" cols="30" class="form-control" rows="2" v-on:keyup.enter="submit"></textarea>
			</div>
			<button class="btn btn-block btn-success" slot="footer" @click="addPeople(statu.id)">Add</button>
		</div>
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
</vue-scroll>
</template>
<script>
import draggable from "vuedraggable";
import axios from 'axios';
import { mapGetters } from 'vuex'
export default {
    middleware: 'auth',
	name: "two-lists",
	display: "Two Lists",
	order: 1,
	components: {
		draggable
	},
	data() {
		return {
			comment:'',
			status:[],
			statu1:[],
			status_id:0,
			isadd:false,
			element:[],
			singletask:[],
		};
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
		async createcommment(e){
	  		if (e.keyCode === 13) {
	  			this.singletask.comments.push({comment:this.comment,user:this.authuser});
				await axios.post('api/comment',{
													    user_id: this.authuser.id,
													    task_id: this.singletask.id,
													    comment: this.comment,
													})
	  			this.comment=''
	  		}
	  	},
		async fetchstatus(id){
			const { data } = await axios.get('api/tasks/'+id)
			this.singletask=data
			console.log(data);
  			this.$refs.modal.show()
		},
		addPeople(id){
			console.log();
			this.isadd=id;
		},
		submit(e){
			var self = this;
			console.log(this.status);
			console.log(e.target.value.length);
			if(e.target.value.length>3){
				console.log(this.isadd);
				axios.post('api/tasks',{
					status_id:this.isadd,
					task_name:e.target.value,
				}).then((res)=>{
					self.status.find(function(element) {
						if(element.id==res.data.status_id){
							element.tasks.push(res.data)
						}
					});
					console.log(res.data);
				})
				this.isadd=false
			}
		},
		abc(element){
			console.log(element);
		},
		add: function(status_id) {
			axios.post('api/taskupdata',{
				task_id:this.element.element.id,
				status_id:status_id,
			}).then((res)=>{
				console.log(res);
			})
		},
		replace: function() {
			this.list = [{ name: "Edgard" }];
		},
		clone: function(el) {
			return {
				name: el.name + " cloned"
			};
		},
		log: function(evt) {
			if(evt.added!=undefined){
				this.element=evt.added;
			}else if(evt.moved){
				let status_id=evt.moved.element.status_id
				let index = this.status.findIndex(x => x.id === status_id)
				let newm1=this.status[index].tasks[evt.moved.newIndex-1] ? this.status[index].tasks[evt.moved.newIndex-1].pos : 0
				let newp1=this.status[index].tasks[evt.moved.newIndex+1] ? this.status[index].tasks[evt.moved.newIndex+1].pos : this.status[index].tasks[evt.moved.newIndex].pos+1
				axios.post('api/posupdata',{
					task_id:this.status[index].tasks[evt.moved.newIndex].id,
					pos:(newm1+newp1)/2,
				}).then((res)=>{
					console.log(res);
				})
			}
		}
	},
	created(){
		var self = this;
		axios.get('api/status').then((red)=>{
			self.status=red.data
		})
	}
};
</script>
<style>
	.__vuescroll{
		height: auto!important;
	}
	.fixed-height{
		max-height: 70vh;
	}
	.modal-backdrop{
		    opacity: .1!important;
	}
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