<template>
<div class="bg-blue w-full h-screen font-sans">
    <div class="flex p-2 bg-blue-dark items-center">
        <div class="mx-0 md:mx-auto">
            <h1 class="text-blue-lighter text-xl flex items-center font-sans italic">
                Hub
            </h1>
        </div>
    </div>
    <div class="flex">
        <draggable v-model="list1" group="people" @start="drag=true" @end="drag=false">
           <div class="w-64 mx-3 bg-white p-2 rounded mt-1 border-b border-grey cursor-pointer hover:bg-grey-lighter" v-for="element in list1" :key="element.id">{{element.name}}</div>
        </draggable>
        <draggable v-model="list2" group="people" @start="drag=true" @end="drag=false">
           <div class="w-64 mx-3 bg-white p-2 rounded mt-1 border-b border-grey cursor-pointer hover:bg-grey-lighter" v-for="element in list2" :key="element.id">{{element.name}}</div>
        </draggable>
        <draggable v-model="list2" group="people" @start="drag=true" @end="drag=false">
           <div class="w-64 mx-3 bg-white p-2 rounded mt-1 border-b border-grey cursor-pointer hover:bg-grey-lighter" v-for="element in list2" :key="element.id">{{element.name}}</div>
        </draggable>
    </div>
</div>
</template>

<script>
import draggable from "vuedraggable";
const message = [
	"vue.draggable",
	"draggable",
	"component",
	"for",
	"vue.js 2.0",
	"based",
	"on",
	"Sortablejs"
];

export default {
	name: "hello",
	components: {
		draggable
	},
	data() {
		return {
			list: message.map((name, index) => {
				return { name, order: index + 1, fixed: false };
			}),
			editable: true,
			isDragging: false,
			delayedDragging: false,
            list1:[
                {
                    "name": "dog 1",
                    "id": 1
                },
                {
                    "name": "dog 2",
                    "id": 2
                },
                {
                    "name": "dog 3",
                    "id": 3
                },
                {
                    "name": "dog 4",
                    "id": 4
                }
            ],
            list2:[
                    {
                        "name": "cat 5",
                        "id": 5
                    },
                    {
                        "name": "cat 6",
                        "id": 6
                    },
                    {
                        "id": 8,
                        "name": "cat 8"
                    },
                    {
                        "name": "cat 7",
                        "id": 7
                    }
            ]
		};
	},
	methods: {
		orderList() {
			this.list = this.list.sort((one, two) => {
				return one.order - two.order;
			});
		},
		onMove({ relatedContext, draggedContext }) {
			const relatedElement = relatedContext.element;
			const draggedElement = draggedContext.element;
			return (
				(!relatedElement || !relatedElement.fixed) && !draggedElement.fixed
			);
		}
	},
	computed: {
		dragOptions() {
			return {
				animation: 0,
				group: "description",
				disabled: !this.editable,
				ghostClass: "ghost"
			};
		},
		listString() {
			return JSON.stringify(this.list, null, 2);
		},
		list2String() {
			return JSON.stringify(this.list2, null, 2);
		}
	},
	watch: {
		isDragging(newValue) {
			if (newValue) {
				this.delayedDragging = true;
				return;
			}
			this.$nextTick(() => {
				this.delayedDragging = false;
			});
		}
	}
};
</script>

<style>
.flip-list-move {
	transition: transform 0.5s;
}

.no-move {
	transition: transform 0s;
}

.ghost {
	opacity: 0.5;
	background: #c8ebfb;
}

.list-group {
	min-height: 20px;
}

.list-group-item {
	cursor: move;
}

.list-group-item i {
	cursor: pointer;
}
</style>
