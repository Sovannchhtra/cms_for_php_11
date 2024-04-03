    users {
        id (PK not null)
        username
        email
        password
        profile
        date
    }

    logos {
        id (PK not null)
        image
        status ( footer , header )
    }

    news {
        id (PK not null)
        user_id (FK)
        title
        date
        description
        news_type
        categories
        banner
        thumbnail
        viewers
    }

    about_us {
        id (PK not null)
        description
    }

    follow_us {
        id (PK not null)
        label
        image
        url
        status ( all,footer )
    }
    
    feedback {
        id (PK not null)
        username
        email
        phone
        address
        description
        date
    }
