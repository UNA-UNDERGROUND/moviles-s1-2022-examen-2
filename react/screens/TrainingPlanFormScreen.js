import { View, Text, TextInput, StyleSheet, TouchableOpacity, Alert } from 'react-native';
import React, { useState, useEffect, useRef } from 'react';
import Layout from '../components/Layout';
import RadioForm, { RadioButton, RadioButtonInput, RadioButtonLabel } from 'react-native-simple-radio-button';
import { getTrainingPlans, createTrainingPlan, updateTrainingPlan } from '../api';
import { NUMBERS, STRINGS, EMAIL, ADDRESS, PHONE, AGE } from '../utils';

const TrainingPlanFormScreen = ({ navigation, route }) => {
    // username is a string
    const [trainingPlan, setTrainingPlan] = useState({
        username: '',
        name: '',
        id: ''
    });
    const [editing, setEditing] = useState(false);
    const [errors, setErrors] = useState({
        username: '',
        name: '',
        id: ''
    });

    const showAlert = (message, success) => {
        Alert.alert(
            "Resultado",
            message,
            [
                {
                    text: "OK", onPress: () => {
                        if (success) {
                            navigation.navigate('HomeScreen');
                        }
                    }
                }
            ]
        );
    };

    const handleChange = (name, value) => setTrainingPlan({ ...trainingPlan, [name]: value });
    const handleEntry = (name, value) => {
        let err = {};
        switch (name) {
            case "username":
                (!STRINGS.test(value)) ? err = { ...err, username: 'Solo se permiten letras en campo usuario' } : err = { ...err, username: '' };
                break;
            case "name":
                (!STRINGS.test(value)) ? err = { ...err, name: 'Solo se permiten letras en campo nombre' } : err = { ...err, name: '' };
                break;
            case "id":
                (!NUMBERS.test(value)) ? err = { ...err, id: 'Solo se permiten 9 números en campo cédula' } : err = { ...err, id: '' };
                break;
        }
        setErrors(err);
    };

    const handleSubmit = () => {
        let err = {};
        if (trainingPlan.username === '') {
            err = { ...err, username: 'El campo usuario es obligatorio' };
        }
        if (trainingPlan.name === '') {
            err = { ...err, name: 'El campo nombre es obligatorio' };
        }
        // id is not required

        if (err.username || err.name || err.id) {
            setErrors(_errors => ({ ..._errors, ...err }));
        }
        else {
            if (editing) {
                updateTrainingPlan(trainingPlan)
                    .then(() => showAlert('Actualización exitosa', true))
                    .catch(() => showAlert('Error al actualizar', false));
            }
            else {
                createTrainingPlan(trainingPlan)
                    .then(() => {
                        showAlert('Registro exitoso', true);
                    })
                    .catch(() => {
                        showAlert('Error al registrar', false);
                    });
            }
        }
    };

    useEffect(() => {
        if (route.params && route.params.id) {
            setEditing(true);
            navigation.setOptions({ title: 'Editar Plan de Entrenamiento' });
            (async () => {
                const trainingPlan = await getTrainingPlans(route.params.id);
                setTrainingPlan(trainingPlan);
            }
            )();
        }
        else {
            navigation.setOptions({ title: 'Nuevo Plan de Entrenamiento' });
        }
    }, []);

    return (
        <Layout>
            <View style={styles.container}>
                <Text style={styles.title}>Usuario</Text>
                <TextInput style={styles.input}
                    value={trainingPlan.username}
                    onChangeText={(value) => handleChange('username', value)}
                    onBlur={() => handleEntry('username', trainingPlan.username)}
                    error={errors.username}
                />
                <Text style={styles.title}>Nombre</Text>
                <TextInput style={styles.input}
                    value={trainingPlan.name}
                    onChangeText={(value) => handleChange('name', value)}
                    onBlur={() => handleEntry('name', trainingPlan.name)}
                    error={errors.name}
                />
                {!editing ? (
                    <TouchableOpacity style={styles.buttonSave} onPress={handleSubmit}>
                        <Text style={styles.buttonText}>Guardar</Text>
                    </TouchableOpacity>
                ) : (
                    <TouchableOpacity style={styles.buttonUpdate} onPress={handleSubmit}>
                        <Text style={styles.buttonText}>Actualizar</Text>
                    </TouchableOpacity>
                )}
            </View>
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
    buttonSave: {
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
    buttonUpdate: {
        paddingTop: 10,
        paddingBottom: 10,
        borderRadius: 5,
        marginBottom: 10,
        backgroundColor: '#e58e26',
        width: '90%'
    },
    errorLabel: {
        color: '#FFFFFF',
        paddingHorizontal: 10,
        paddingBottom: 5,
        backgroundColor: "#FF0000",
        borderRadius: 5,
    }
})

export default TrainingPlanFormScreen;


