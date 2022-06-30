/**
 * Sample React Native App
 * https://github.com/facebook/react-native
 *
 * @format
 * @flow strict-local
 */

import React from 'react';
import {Text, TouchableOpacity} from 'react-native';
import { NavigationContainer } from '@react-navigation/native';
import { createNativeStackNavigator } from '@react-navigation/native-stack';


import HomeScreen from './screens/HomeScreen';
import TrainingPlanFormScreen from './screens/TrainingPlanFormScreen';

const Stack = createNativeStackNavigator();
const App = () => {
  return (
    <NavigationContainer>
      <Stack.Navigator>
        <Stack.Screen name="HomeScreen" component={HomeScreen} options={({navigation})=>({
          title: 'Lista de Planes de Entrenamiento',
          headerStyle: {backgroundColor: '#222f3e'}, 
          headerTitleStyle:{color: '#FFFFFF'},
          headerRight: () => (
            <TouchableOpacity onPress={()=>navigation.navigate('TrainingPlanFormScreen')}>
              <Text style={{color:'#FFFFFF', marginRight: 20, fontSize: 15}}>Nueva</Text>
            </TouchableOpacity>
          ),
          })}/>
        <Stack.Screen name="TrainingPlanFormScreen" component={TrainingPlanFormScreen} 
          options={{
            title: 'Agregar Nuevo plan de entremaniento', 
            headerStyle:{
              backgroundColor: '#222f3e',
            },
            headerTitleStyle:{
              color: '#FFFFFF',
            },
            headerTintColor: '#FFFFFF', 
        }}
        />
      </Stack.Navigator>
    </NavigationContainer>
  );
};
export default App;
