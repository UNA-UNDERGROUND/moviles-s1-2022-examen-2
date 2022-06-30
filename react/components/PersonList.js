import { FlatList, RefreshControl ,Alert } from 'react-native';
import React, {useEffect,useState} from 'react';
import { useIsFocused } from '@react-navigation/native';
import PersonItem from './PersonItem';

import {getPersonInformation, deletePerson} from '../api';

const PersonList = () => {

    const [persons, setPersons] = useState([]);
    const [refreshing, setRefreshing] = useState(false);
    const isFocused = useIsFocused();
    const loadPersonInformation = async () => {
      getPersonInformation().then((data) =>{
        setPersons(data.person)
      }).catch((error)=>{
        console.error(error.message);
      });
    }
    const showConfirmation = async (person)=>{
      Alert.alert(
        "Alerta",
        "¿Seguro que quieres eliminar el registro?",
        [
          { text: "Cancelar"},
          { text: "Si", onPress: () => {
            deletePerson(person).then((response)=>{
              Alert.alert(
                "Resultado",
                response[0].message,
                [
                  { text: "OK", onPress:async()=>{ await loadPersonInformation();}}
                ]
            );}
            );
          }}
        ]
      );
    };

    const handleDelete = async (person) => {
      await showConfirmation(person);
    };
    //se va a ejecutar cuando se cargue la pantalla (onload en web)
    useEffect(() => {
      loadPersonInformation()
    }, [isFocused]);
    const renderItem = ({item})=>{
      return <PersonItem person={item} handleDelete={handleDelete}/>
    };

    const onRefresh = React.useCallback(async () =>{
      setRefreshing(true);
      await loadPersonInformation();
      setRefreshing(false);
    });
  return (
    <FlatList
        style={{width: '100%'}}
        data={persons}
        keyExtractor={(item) => item.identification + ''}
        renderItem={renderItem}
        refreshControl={<RefreshControl refreshing={refreshing} onRefresh={onRefresh}/>}
      />
  );
};

export default PersonList