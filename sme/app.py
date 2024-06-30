from flask import Flask, request, jsonify
from flask_cors import CORS
import spacy
from pyjarowinkler import distance
import requests
import re

app = Flask(__name__)
CORS(app)
nlp = spacy.load("en_core_web_lg")

# Preprocessing function
def preprocess_text(text):
    cleaned_text = re.sub(r'\b[a-zA-Z]\d?\)?\.?', '', text)
    cleaned_text = re.sub(r'\d+\)?\.?', '', cleaned_text)
    cleaned_text = re.sub(r'[^\w\s]', '', cleaned_text)
    return cleaned_text.strip()

# Function to get related words from Datamuse
def get_related_words(text):
    try:
        response = requests.get(f'https://api.datamuse.com/words?ml={text}')
        response.raise_for_status()
        words = response.json()
        return [word['word'] for word in words]
    except requests.RequestException as e:
        print(f"Error fetching related words: {e}")
        return []

# Function to calculate similarity
def calculate_similarity(text1, text2):
    # Preprocess texts
    text1 = preprocess_text(text1)
    text2 = preprocess_text(text2)
    
    related_words1 = ' '.join(get_related_words(text1))
    related_words2 = ' '.join(get_related_words(text2))
    
    enriched_text1 = f"{text1} {related_words1}"
    enriched_text2 = f"{text2} {related_words2}"
    
    doc1 = nlp(enriched_text1)
    doc2 = nlp(enriched_text2)
    spacy_similarity_score = doc1.similarity(doc2)
    
    jaro_winkler_score = distance.get_jaro_distance(enriched_text1, enriched_text2, winkler=True, scaling=0.1)
    
    combined_similarity = (jaro_winkler_score + spacy_similarity_score) / 2
    return combined_similarity

@app.route('/calculate_similarity', methods=['POST'])
def similarity():
    try:
        data = request.json
        if not data or 'text1' not in data or 'text2' not in data:
            return jsonify({'error': 'Invalid input'}), 400
        
        text1 = data['text1']
        text2 = data['text2']
        
        similarity_score = calculate_similarity(text1, text2)
        similarity_percent = round(similarity_score * 100, 2)
        return jsonify({'similarity': f'{similarity_percent}%'})
    except Exception as e:
        print(f"Error calculating similarity: {e}")
        return jsonify({'error': 'Internal server error'}), 500

if __name__ == "__main__":
    app.run(debug=True)
