import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { FaRegUserCircle } from "react-icons/fa";

const Navbar = () => {
  const [isLoggedIn, setIsLoggedIn] = useState(false);
  const [userData, setUserData] = useState(null);

  useEffect(() => {
    const storedIsLoggedIn = localStorage.getItem('isLoggedIn');
    const storedUserData = localStorage.getItem('userData');

    if (storedIsLoggedIn === 'true' && storedUserData) {
      setIsLoggedIn(true);
      try {
        const parsedUserData = JSON.parse(storedUserData);
        setUserData(parsedUserData?.user); 
      } catch (err) {
        console.error('Error parsing user data:', err);
      }
    }
  }, []);

  const handleLogout = () => {
    localStorage.removeItem('isLoggedIn');
    localStorage.removeItem('userData');
    setIsLoggedIn(false);
    setUserData(null);

    // Optionally, redirect to home page after logout
    window.location.href = '/';
  };

  return (
    <header className='py-6 border-b border-gray-200'>
      <div className="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <Link to="/" className='text-2xl font-bold text-black'>News</Link>
        <div className='flex gap-6'>
          {!isLoggedIn ? (
            <>
              <Link to="/register">
                <button className='px-6 py-2 bg-black text-white border border-transparent hover:bg-transparent hover:text-black hover:border-black transition-all duration-200'>
                  Register
                </button>
              </Link>
              <Link to="/login">
                <button className='px-6 py-2 bg-black text-white border border-transparent hover:bg-transparent hover:text-black hover:border-black transition-all duration-200'>
                  Login
                </button>
              </Link>
            </>
          ) : (
            <>
              <button
                onClick={handleLogout}
                className='px-6 py-2 bg-black text-white border border-transparent hover:bg-transparent hover:text-black hover:border-black transition-all duration-200'
              >
                Logout
              </button>
              <Link to="/profile">
                <button className='uppercase px-6 py-2 bg-black text-white border border-transparent hover:bg-transparent hover:text-black hover:border-black transition-all duration-200 flex items-center gap-2'>
                  <FaRegUserCircle />
                  {userData?.name || 'Username'}
                </button>
              </Link>
            </>
          )}
        </div>
      </div>
    </header>
  );
};

export default Navbar;
