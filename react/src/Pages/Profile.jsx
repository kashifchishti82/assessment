import React, { useState, useEffect } from 'react';
import Navbar from '../Components/Navbar';

const Profile = () => {
  const [userData, setUserData] = useState(null);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const storedUserData = localStorage.getItem('userData');
    // console.log(storedUserData, "storedUserData");

    if (storedUserData) {
      try {
        const parsedData = JSON.parse(storedUserData);
        setUserData(parsedData);
        // console.log(parsedData, "userData");
        setIsLoading(false);
      }
      catch (err) {
        console.error('Error parsing user data:', err);
        setError('Failed to retrieve user information.');
        setIsLoading(false);
      }
    }
    else {
      console.warn('User is not logged in. Redirecting to login page...');
      setError('You are not logged in. Please log in to view your profile.');
      setIsLoading(false);
    }
  }, []);

  if (isLoading) {
    return <p className='container max-w-7xl mx-auto px-4 py-8'>Loading user information...</p>;
  }

  if (error) {
    return <p className="text-red-500 container max-w-7xl mx-auto px-4 py-8">{error}</p>;
  }

  return (
    <>
      <Navbar />
      <div className="container max-w-7xl mx-auto space-y-4 my-8 px-4 sm:px-6 lg:px-8 sm:space-y-0 py-5">
        <h1 className="text-2xl font-bold text-black">User Information</h1>

        {userData && userData.user && (
          <div className='py-5'>
            <p>Name: {userData.user.name}</p>
            <p>Email: {userData.user.email}</p>
          </div>
        )}
      </div>
    </>
  );
};

export default Profile;
