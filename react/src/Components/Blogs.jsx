import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';

const Blogs = () => {

  const [searchTerm, setSearchTerm] = useState('');
  const [selectedSource, setSelectedSource] = useState('');
  const [selectedAuthor, setSelectedAuthor] = useState('');
  const [selectedOrder, setSelectedOrder] = useState('');
  const [blogData, setBlogData] = useState([]);
  const [sources, setSources] = useState([]);
  const [authors, setAuthors] = useState([]);
  const [loading, setLoading] = useState(true);
  const [isLoggedIn, setIsLoggedIn] = useState(false);
  const [userPreferences, setUserPreferences] = useState({});

  const API_NEWS_ENDPOINT = `${import.meta.env.VITE_API_BASE_URL}api/news`;

  // Fetch user data and preferences from localStorage
  useEffect(() => {
    const storedIsLoggedIn = localStorage.getItem('isLoggedIn');
    const storedUserData = localStorage.getItem('userData');

    if (storedIsLoggedIn === 'true' && storedUserData) {
      setIsLoggedIn(true);
      const parsedUserData = JSON.parse(storedUserData);

      if (parsedUserData?.user?.preferences) {
        const preferences = parsedUserData.user.preferences;
        setSelectedOrder(preferences.order_by || 'ASC');
        setSelectedAuthor(preferences.author_id || '');
        setSelectedSource(preferences.source_id || '');
      } else {
        console.log('No preferences found for the user.');
      }
    }
  }, []);

  // Fetch blogs with filters applied
  useEffect(() => {
    const fetchBlogs = async () => {
      try {
        setLoading(true);
        const queryParams = new URLSearchParams();

        if (searchTerm) queryParams.append('search', searchTerm);
        if (selectedSource) queryParams.append('source_id', selectedSource);
        if (selectedAuthor) queryParams.append('author_id', selectedAuthor);
        if (selectedOrder) queryParams.append('order_by', selectedOrder);

        const response = await fetch(`${API_NEWS_ENDPOINT}?${queryParams.toString()}`);
        const data = await response.json();
        setBlogData(data);

        const fetchedSources = Array.from(new Set(data.map(blog => blog.source)));
        setSources(fetchedSources);

        const fetchedAuthors = Array.from(new Set(data.flatMap(blog => blog.authors)));
        setAuthors(fetchedAuthors);
      } catch (error) {
        console.error('Error fetching blogs:', error);
      } finally {
        setLoading(false);
      }
    };

    fetchBlogs();
  }, [searchTerm, selectedSource, selectedAuthor, selectedOrder]);

  // Save User Preferences
  const savePreferences = async () => {
    if (!isLoggedIn) {
      alert('Please log in to save your preferences.');
      return;
    }

    try {
      const token = localStorage.getItem('token');
      if (!token) {
        alert('No token found. Please log in again.');
        return;
      }

      const response = await fetch(
        `${API_NEWS_ENDPOINT.replace('/news', '/preferences')}`,
        {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`,
          },
          body: JSON.stringify({
            order_by: selectedOrder,
            author_id: selectedAuthor,
            source_id: selectedSource,
          }),
        }
      );

      const data = await response.json();
      if (data.success) {
        alert('Preferences saved successfully!');
        const userData = JSON.parse(localStorage.getItem('userData')) || {};
        userData.user.preferences = {
          order_by: selectedOrder,
          author_id: selectedAuthor,
          source_id: selectedSource,
        };
        localStorage.setItem('userData', JSON.stringify(userData));
        setUserPreferences(userData.user.preferences);
      } else {
        alert(data.message || 'Failed to save preferences.');
      }
    } catch (error) {
      console.error('Error saving preferences:', error);
      alert('Error saving preferences.');
    }
  };

  // Apply Filters
  const applyFilters = async () => {
    try {
      setLoading(true);
      const queryParams = new URLSearchParams();

      if (searchTerm) queryParams.append('search', searchTerm);
      if (selectedSource) queryParams.append('source_id', selectedSource);
      if (selectedAuthor) queryParams.append('author_id', selectedAuthor);
      if (selectedOrder) queryParams.append('order_by', selectedOrder);

      const response = await fetch(`${API_NEWS_ENDPOINT}?${queryParams.toString()}`);
      const filteredData = await response.json();
      setBlogData(filteredData);
    } catch (error) {
      console.error('Error applying filters:', error);
    } finally {
      setLoading(false);
    }
  };


  if (loading) {
    return <p className="text-center">Loading blogs...</p>;
  }

  return (
    <>
      {/* Filters */}
      <div className="container max-w-7xl mx-auto space-y-4 my-8 px-4 sm:px-6 lg:px-8 sm:space-y-0 sm:flex sm:flex-wrap sm:gap-4 py-5">

        {/* First */}
        <div className='w-full flex flex-wrap justify-between gap-4'>
          {/* Search Input */}
          <input
            type="text"
            placeholder="Search News"
            value={searchTerm}
            onChange={(e) => setSearchTerm(e.target.value)}
            className="w-full sm:flex-1 px-4 py-2 text-black placeholder-gray-500 bg-white border border-gray-300 rounded-none appearance-none focus:outline-none focus:ring-1 focus:ring-black focus:border-black transition-colors duration-200"
          />
          {/* Source Selectbox */}
          <select
            value={selectedSource}
            onChange={(e) => setSelectedSource(e.target.value)}
            className="w-full sm:w-auto px-4 py-2 text-black bg-white border border-gray-300 rounded-none appearance-none focus:outline-none focus:ring-1 focus:ring-black focus:border-black transition-colors duration-200"
          >
            <option value="">All Sources</option>
            {sources
              .filter((value, index, self) =>
                index === self.findIndex((t) => t.id === value.id)
              )
              .map((source) => (
                <option key={source.id} value={source.id}>
                  {source.name}
                </option>
              ))}
          </select>

          {/* Order Selectbox */}
          <select
            value={selectedOrder}
            onChange={(e) => setSelectedOrder(e.target.value)}
            className="w-full sm:w-auto px-4 py-2 text-black bg-white border border-gray-300 rounded-none appearance-none focus:outline-none focus:ring-1 focus:ring-black focus:border-black transition-colors duration-200"
          >
            <option value="">Sort By</option>
            <option value="asc">Ascending</option>
            <option value="desc">Descending</option>
          </select>
        </div>

        {/* Second */}
        <div className='w-full flex flex-wrap justify-start gap-4'>
          {/* Author Selectbox */}
          <select
            value={selectedAuthor}
            onChange={(e) => setSelectedAuthor(e.target.value)}
            className="w-full sm:w-auto px-4 py-2 text-black bg-white border border-gray-300 rounded-none appearance-none focus:outline-none focus:ring-1 focus:ring-black focus:border-black transition-colors duration-200"
          >
            <option value="">All Authors</option>
            {authors.map((author) => (
              <option key={author.pivot.author_id} value={author.pivot.author_id}>
                {author.name}
              </option>
            ))}
          </select>
          {/* Apply Button */}
          <button
            onClick={applyFilters}
            className="px-6 py-2 bg-black text-white border border-transparent hover:bg-transparent hover:text-black hover:border-black transition-all duration-200"
          >
            Apply Filters
          </button>
          {/* Prefernce Button */}
          {isLoggedIn && (
            <button
              onClick={savePreferences}
              className="px-6 py-2 bg-black text-white border border-transparent hover:bg-transparent hover:text-black hover:border-black transition-all duration-200 mx-4 md:mx-0 "
            >
              Save Preferences
            </button>
          )}

        </div>

      </div>

      {/* Blog List */}
      <div className="container max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 px-4 sm:px-6 lg:px-8 py-5">
        {blogData.length > 0 ? (
          blogData.map((blog, index) => (
              <div className="space-y-4" key={index}>
                <div className="aspect-[4/3] overflow-hidden bg-gray-100">
                  <img
                    className="w-full h-full object-cover"
                    src={blog.images?.[0]?.url || 'https://fakeimg.pl/600x400?text=Placeholder'}
                    alt={blog.title || 'Blog Image'}
                  />

                </div>
                <h3 className="text-lg font-semibold text-gray-900">{blog.title}</h3>
                <p className="text-sm text-gray-600">
                  {blog.source.name} - {blog.published_at} -{' '}
                  {blog.authors?.[0]?.name && <span>{blog.authors[0].name}</span>}
                </p>
                <button className="bg-black text-white px-6 py-2 rounded-none border border-transparent hover:bg-transparent hover:text-black hover:border-black transition-all duration-200">
                  Read More
                </button>
              </div>
          ))
        ) : (
          <p className="text-center text-gray-600">No blogs match your criteria.</p>
        )}
      </div>
    </>
  );
};

export default Blogs;

