<template>
    <div>
        <div class="form-group">
            <span><label for="question">Answer type</label></span> (<span class="text-danger">Required</span>)
            <br>
            <span>Would this question be open ended or an objective type</span>
            <select v-model="answer_type" name="answer_type" id="answer_type" class="form-control">
                <option value="open_ended">Open Ended</option>
                <option value="objective_type">Objective Type</option>
            </select>
        </div>
        <div class="form-group" v-if="answer_type == 'objective_type'">
            <span><label for="question">Answers</label></span> (<span class="text-danger">Required</span>)
            <br>
            <span>Two or more answers for this question depending on the expected outcome</span>
            <div v-for="answer in answers">
                <span class="text-success" >- {{ answer }}</span><br>
            </div>
            <input type="hidden" name="answers" :value="answers">
            <span>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <input type="text" v-model="answer"
                               placeholder="Type answers here"
                               class="form-control">
                        <div class="input-group-text" @click="addAnswer(answer)"> Add option</div>
                    </div>
                </div>
            </span>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'AnswerForm',
        data() {
            return {
                answer_type: 'objective_type',
                answers: [],
                answer: ''
            }
        },
        created() {

        },
        methods: {
            addAnswer(answer, event){
                if (answer.length == 0) {
                    alert('You need to provide an answer')
                    return
                }
                this.answers.push(answer)
                this.answer = ''
            }
        },
    }
</script>

<style scoped>
    .add-btn {
        margin-top: 10px;
    }
</style>