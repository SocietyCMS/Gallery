<style>
    .Alert {
        padding: 10px;
        position: absolute;
        bottom: 40px;
        right: 40px;
    }
    .Alert--Success {
        border: 10px solid green;
    }
    .Alert--Error {
        border: 10px solid red;
    }
</style>

<template>
    <div :class="alertClass"
         v-show="show"
    >
        <p>
            <slot></slot>
        </p>
    </div>
</template>

<script>
    export default {
        props: ['type'],
        data: function() {
            return {
                show: true
            };
        },
        ready: function() {
            setTimeout(function(){ this.show = false}, 3000);
        },
        computed: {
            alertClass: function() {
                var type = this.type;

                return {
                    'Alert': true,
                    'Alert--Scuccess' : type== 'success',
                    'Alert--Error' : type== 'error'
                }
            }
        }
    };
</script>
