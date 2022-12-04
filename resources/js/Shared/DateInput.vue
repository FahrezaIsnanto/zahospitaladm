<template>
    <div :class="$attrs.class">
      <label v-if="label" class="form-label" :for="id">{{ label }}:</label>
      <input :id="id" ref="input" v-bind="{ ...$attrs, class: null }" class="form-input" :class="{ error: error }" :type="type" :value="modelValue" @input="handleUpdateModelValue" />
      <div v-if="error" class="form-error">{{ error }}</div>
    </div>
  </template>
  
  <script>
  import { v4 as uuid } from 'uuid'
  
  export default {
    inheritAttrs: false,
    props: {
      id: {
        type: String,
        default() {
          return `text-input-${uuid()}`
        },
      },
      type: {
        type: String,
        default: 'text',
      },
      error: String,
      label: String,
      modelValue: String,
    },
    emits: ['update:modelValue'],
    methods: {
      focus() {
        this.$refs.input.focus()
      },
      select() {
        this.$refs.input.select()
      },
      setSelectionRange(start, end) {
        this.$refs.input.setSelectionRange(start, end)
      },
      handleUpdateModelValue(event){
        let data = event.target.value;
        data = data.replace(/-/g,"");
        let newData = ''; 
        for ( let str = 0; data.length > str; ++str )
        {
            if( str % 2 === 0 && str !== 0 && str < 5) {
                newData += '-',newData += data[str - 0];
            }else{ 
                newData += data[str]
            }
                
        }
        this.$emit('update:modelValue', newData)
      }
    },
  }
  </script>
  