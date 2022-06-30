import { View, Text, StyleSheet, StatusBar, TouchableOpacity } from 'react-native';
import React from 'react';
import { useNavigation } from '@react-navigation/native';

const TrainingPlanItem = ({ trainingPlan, handleDelete }) => {

    const navigation = useNavigation();
    return (
        <View style={styles.itemContainer}>
            <TouchableOpacity onPress={() => navigation.navigate('TrainingPlanFormScreen', { id: trainingPlan.id })}>
                <Text style={styles.itemTitle}>{"Usuario: " + trainingPlan.username}</Text>
                <Text style={styles.itemTitle}>{"Nombre: " + trainingPlan.name}</Text>
            </TouchableOpacity>
            <TouchableOpacity style={styles.deleteButton} onPress={() => { handleDelete(trainingPlan) }}><Text style={styles.itemTitle}>Eliminar</Text></TouchableOpacity>
        </View>
    );
}

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
    deleteButton: {
        backgroundColor: '#ee5253',
        padding: 7,
        borderRadius: 5,
    }
});

export default TrainingPlanItem;