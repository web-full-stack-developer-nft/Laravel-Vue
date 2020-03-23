<template>
	<div class="row">
		<div class="flex px-4 pb-8 items-start"> 
			<div v-for="statu in status" class="rounded bg-blue-400 flex-no-shrink w-64 p-2 mr-3">
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
							>
								{{ task.name }}
								<Model :task="task"/>
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
	</div>
</template>
<script>
import draggable from "vuedraggable";
import axios from 'axios';
export default {
	name: "two-lists",
	display: "Two Lists",
	order: 1,
	components: {
		draggable
	},
	data() {
		return {
			status:[],
			statu1:[],
			status_id:0,
			isadd:false,
			element:[]
		};
	},
	methods: {
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
			axios.post('api/update',{
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
</style>