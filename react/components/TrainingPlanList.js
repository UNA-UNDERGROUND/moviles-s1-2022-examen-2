import { FlatList, RefreshControl, Alert } from "react-native";
import React, { useEffect, useState } from "react";
import { useIsFocused } from "@react-navigation/native";


import { getTrainingPlans, deleteTrainingPlan } from "../api";
import TrainingPlanItem from "./TrainingPlanItem";

const TrainingPlanList = () => {

    const [trainingPlans, setTrainingPlans] = useState([]);
    const [refreshing, setRefreshing] = useState(false);
    const isFocused = useIsFocused();
    const loadTrainingPlans = async () => {
        getTrainingPlans().then((data) => {
            setTrainingPlans(data);
        }).catch((error) => {
            console.error(error.message);
        });
    }
    const showConfirmation = async (trainingPlan) => {
        Alert.alert(
            "Alerta",
            "¿Seguro que quieres eliminar el registro?",
            [
                { text: "Cancelar" },
                {
                    text: "Si", onPress: () => {
                        deleteTrainingPlan(trainingPlan.id).then((response) => {
                            console.log(response);
                            debugger;
                            // returns true or false
                            if (response) {
                                loadTrainingPlans();
                            }
                            else {
                                console.log("Error");
                            }
                        }
                        );
                    }
                }
            ]
        );
    };

    const handleDelete = async (trainingPlan) => {
        await showConfirmation(trainingPlan);
    }

    //se va a ejecutar cuando se cargue la pantalla (onload en web)
    useEffect(() => {
        loadTrainingPlans()
    }, [isFocused]);
    const renderItem = ({ item }) => {
        return <TrainingPlanItem trainingPlan={item} handleDelete={handleDelete} />
    }

    const onRefresh = React.useCallback(async () => {
        setRefreshing(true);
        await loadTrainingPlans();
        setRefreshing(false);
    });

    return (
        <FlatList
            style={{ width: '100%' }}
            data={trainingPlans}
            renderItem={renderItem}
            keyExtractor={(item) => item.id}
            refreshControl={<RefreshControl refreshing={refreshing} onRefresh={onRefresh} />}
        />
    );
};

export default TrainingPlanList;
