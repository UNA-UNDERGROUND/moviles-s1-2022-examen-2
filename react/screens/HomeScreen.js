import { View, Text} from 'react-native';
import React from 'react';
import PersonList from '../components/PersonList';
import TraininngPlanList from '../components/TrainingPlanList';
import Layout from '../components/Layout';

const HomeScreen = () => {

  
  return (
    <Layout>
      <TraininngPlanList/>
    </Layout>
  );
};

export default HomeScreen