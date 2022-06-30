import { View, Text, TextInput, StyleSheet, TouchableOpacity, Alert} from 'react-native';
import React, {useState, useEffect, useRef} from 'react';
import Layout from '../components/Layout';
import RadioForm, { RadioButton, RadioButtonInput, RadioButtonLabel} from 'react-native-simple-radio-button';
import {savePerson, getPerson, updatePerson} from '../api';
import { NUMBERS, STRINGS, EMAIL, ADDRESS, PHONE, AGE } from '../utils';

const PersonFormScreen = ({navigation, route}) => {
  var sexOptions = [
    {label: "M", value: "M"},
    {label: "F", value: "F"},
  ];
  const radioButtonRef = useRef(null);

  const [person, setPerson] = useState({
    identification: '',
    name: '',
    lastName: '',
    address: '',
    phone: '',
    email: '',
    age: '',
    sex: ''
  });
  const [editing, setEditing] = useState(false);
  const [errors, setErrors] = useState({
    identification: '',
    name: '',
    lastName: '',
    address: '',
    phone: '',
    email: '',
    age: '',
    sex: ''
  });

  const showAlert = (message, success) => {
    Alert.alert(
      "Resultado",
      message,
      [
        { text: "OK", onPress: () => {
          if (success){
            navigation.navigate('HomeScreen');
          }
        }}
      ]
    );
  };

  const handleChange = (name, value) => setPerson({...person, [name]: value});
  const handleEntry = (name,value) => {
    let err = {};
    switch(name){
      case "identification":
        (!NUMBERS.test(value))? err = {...err, identification: 'Solo se permiten 9 números en campo cédula'}:err = {...err, identification: ''};
      break;
      case "age":
        (!AGE.test(value))? err = {...err, age: 'Solo se permiten números enteros en campo edad'}:err = {...err, age: ''};
      break;
      case "name":
        (!STRINGS.test(value))? err = {...err, name: 'Solo se permiten letras en campo nombre'}:err = {...err, name: ''};
      break;
      case "lastName":
        (!STRINGS.test(value))? err = {...err, lastName: 'Solo se permiten letras en campo Apellidos'}:err = {...err, lastName: ''};
      break;
      case "email":
        (!EMAIL.test(value))? err = {...err, email: 'Por favor, digite un correo válido '}:err = {...err, email: ''};
      break;
      case "address":
        (!ADDRESS.test(value))? err = {...err, address: 'Solo se permiten letras, puntos y comas en campo dirección'}:err = {...err, address: ''};
      break;
      case "phone":
        (!PHONE.test(value))? err = {...err, phone: 'Solo se permiten 8 números en campo teléfono'}:err = {...err, phone: ''};
      break;
      case "sex":
        (person.sex === null)? err = {...err, sex: 'Complete este campo'}:err = {...err, sex: ''};
      break;
        default: 
        break;
    }
    setErrors(_errors => ({..._errors, ...err}));
  };
  const handleSubmit = () =>{
    let err = {};
    if (!person.identification) err = {...err, identification:'Complete este campo'};
    if (!person.name) err = {...err, name:'Complete este campo'};
    if (!person.lastName) err = {...err, lastName: 'Complete este campo'};
    if (!person.age) err = {...err, age:'Complete este campo'};
    if (!person.address) err = {...err, address:'Complete este campo'};
    if (!person.sex) err = {...err, sex:'Complete este campo'};

    if (err.identification || err.name || err.lastName || err.age || err.address || err.sex || errors.phone || errors.email){
      setErrors(_errors => ({..._errors, ...err}));
    }else{
      if (!editing){
        savePerson(person).then((response) =>{
          showAlert(response[0].message, response[0].success);
        });
      }else{
        updatePerson(person).then((response) =>{
          showAlert(response[0].message, response[0].success);
        });
      }
    }
  };

  useEffect(()=>{
    if (route.params && route.params.identification){
      setEditing(true);
      navigation.setOptions({headerTitle: 'Modificar Persona'});
      (async ()=>{
        const res = await getPerson(route.params.identification);
        console.log(res);
        setPerson({
          identification: res.identification,
          name: res.name,
          lastName: res.lastName,
          address: res.address,
          phone: res.phone,
          email: res.email,
          age: res.age,
          sex: res.sex
        });
        if (res.sex == "M"){
          radioButtonRef.current.updateIsActiveIndex(0);
        }else{
          radioButtonRef.current.updateIsActiveIndex(1);
        }
      })();
    }
  }, []);
  return (
    <Layout>
      <TextInput style={styles.input} keyboardType='numeric' placeholder='Cédula' placeholderTextColor="#546574" maxLength={9} onChangeText={(text)=>{
          handleChange('identification', text);
          handleEntry('identification', text);
        }} value={person.identification} editable={!editing?true:false}/>
      {errors.identification?<Text style={styles.errorLabel}>{errors.identification}</Text>:null}
      <TextInput style={styles.input} placeholder='Nombre' placeholderTextColor="#546574" maxLength={30} onChangeText={(text)=> {
        handleChange('name', text);
        handleEntry('name', text);
      }} value={person.name} editable={!editing?true:false}/>
      {errors.name?<Text style={styles.errorLabel}>{errors.name}</Text>:null}
      <TextInput style={styles.input} placeholder='Apellidos' placeholderTextColor="#546574" maxLength={30} onChangeText={(text)=> {
        handleChange('lastName', text);
        handleEntry('lastName', text);
      }} value={person.lastName} editable={!editing?true:false}/>
      {errors.lastName?<Text style={styles.errorLabel}>{errors.lastName}</Text>:null}
      <TextInput style={styles.input} keyboardType='numeric' placeholder='Edad' placeholderTextColor="#546574" maxLength={3} onChangeText={(text)=>{
        handleChange('age', text);
        handleEntry('age', text);
      }} value={person.age} editable={!editing?true:false}/>
      {errors.age?<Text style={styles.errorLabel}>{errors.age}</Text>:null}
      <TextInput style={styles.input} placeholder='Correo' placeholderTextColor="#546574" maxLength={100} onChangeText={(text)=> {
        handleChange('email', text);
        handleEntry('email', text);
      }} value={person.email}/>
      {errors.email?<Text style={styles.errorLabel}>{errors.email}</Text>:null}
      <TextInput style={styles.input} placeholder='Dirección' placeholderTextColor="#546574" maxLength={300} onChangeText={(text)=> {
        handleChange('address', text);
        handleEntry('address', text);
      }} value={person.address}/>
      {errors.address?<Text style={styles.errorLabel}>{errors.address}</Text>:null}
      <TextInput style={styles.input} keyboardType='numeric'placeholder='Teléfono' placeholderTextColor="#546574" maxLength={8} onChangeText={(text)=> {
        handleChange('phone', text);
        handleEntry('phone', text);
      }} value={person.phone}/>
      {errors.phone?<Text style={styles.errorLabel}>{errors.phone}</Text>:null}
      <Text>Sexo</Text>
      <RadioForm
          radio_props={sexOptions}
          ref={radioButtonRef}
          initial={-1}
          onPress={(value) => {
            handleChange('sex', value.toString());
            handleEntry('sex', value.toString());
          }}
          buttonSize={10}
          buttonOuterSize={20}
          selectedButtonColor={'green'}
          selectedLabelColor={'green'}
          labelStyle={{ fontSize: 20, color: '#FFFFFF'}}
          disabled={!editing?false:true}
          formHorizontal={false}
        />
        {errors.sex?<Text style={styles.errorLabel}>{errors.sex}</Text>:null}
        {!editing?(
          <TouchableOpacity style={styles.buttonSave} onPress={handleSubmit}>
            <Text style={styles.buttonText}>Guardar Persona</Text>
          </TouchableOpacity>
        ):(
          <TouchableOpacity style={styles.buttonUpdate} onPress={handleSubmit}>
            <Text style={styles.buttonText}>Actualizar Persona</Text>
          </TouchableOpacity>
      )}
      
    </Layout>
  );
};

const styles = StyleSheet.create({
  input: {
    width: '90%',
    marginBottom: 7,
    fontSize: 14,
    borderWidth: 1,
    borderColor: '#10ac84',
    height: 35,
    color: '#FFFFFF',
    textAlign: 'center',
    borderRadius: 5,
    padding: 4,
  },
  buttonSave:{
    paddingTop: 10,
    paddingBottom: 10,
    borderRadius: 5,
    marginBottom: 10,
    backgroundColor: '#10ac84',
    width: '90%'
  },
  buttonText: {
    color: '#FFFFFF',
    textAlign: 'center',
  },
  buttonUpdate:{
    paddingTop: 10,
    paddingBottom: 10,
    borderRadius: 5,
    marginBottom: 10,
    backgroundColor: '#e58e26',
    width: '90%'
  },
  errorLabel:{
    color: '#FFFFFF',
    paddingHorizontal: 10,
    paddingBottom: 5,
    backgroundColor: "#FF0000",
    borderRadius: 5,
  }
})
export default PersonFormScreen