import { View, Text, StyleSheet, TouchableOpacity } from 'react-native';
import React from 'react';
import { useNavigation } from '@react-navigation/native';

const PersonItem = ({person, handleDelete}) => {

  const navigation = useNavigation();
  return (
    <View style={styles.itemContainer}>
      <TouchableOpacity onPress={()=>navigation.navigate('PersonFormScreen', {identification: person.identification})}>
        <Text style={styles.itemTitle}>{"Cédula: " + person.identification}</Text>
        <Text style={styles.itemTitle}>{"Nombre: " + person.name}</Text>
        <Text style={styles.itemTitle}>{"Apellidos: " + person.lastName}</Text>
        <Text style={styles.itemTitle}>{"Sexo: " + person.sex}</Text>
        <Text style={styles.itemTitle}>{"Teléfono: " + person.phone}</Text>
        <Text style={styles.itemTitle}>{"correo: " + person.email}</Text>
      </TouchableOpacity>
      <TouchableOpacity style={styles.deleteButton} onPress={()=>{handleDelete(person)}}><Text style={styles.itemTitle}>Eliminar</Text></TouchableOpacity>
    </View>
  );
};

const styles = StyleSheet.create({
    itemContainer: {
        backgroundColor: '#FFFFFF',
        padding: 20,
        marginVertical: 8,
        borderRadius: 5,
        flexDirection: 'row',
        justifyContent: 'space-between',
        alignItems: 'center',
    },
    itemTitle: {
        color: '#000000'
    },
    deleteButton:{
        backgroundColor: '#ee5253',
        padding: 7,
        borderRadius: 5,
    }
});

export default PersonItem