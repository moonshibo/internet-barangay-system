
"""Text preprocessing for the IntRENEt NLP baseline.

This module normalizes concern text for TF-IDF feature extraction.
It does not assign labels, approve rows, or determine whether a report is true.
"""

import re
import unicodedata


def preprocess_text(text: str) -> str:
    """Normalize a concern while preserving meaningful words and numbers."""
    if not isinstance(text, str):
        return ""

    # Normalize Unicode and lowercase text.
    text = unicodedata.normalize("NFKC", text).lower()

    # Replace URLs and email addresses with spaces.
    text = re.sub(r"https?://\S+|www\.\S+", " ", text)
    text = re.sub(r"\b[\w.+-]+@[\w.-]+\.[a-z]{2,}\b", " ", text)

    # Remove common placeholders without removing ordinary words.
    text = re.sub(r"\(street\)|\[street\]|\{street\}", " ", text)

    # Keep letters and numbers from Filipino, English, and mixed-language text.
    text = re.sub(r"[^\w\s]", " ", text, flags=re.UNICODE)
    text = re.sub(r"_+", " ", text)
    text = re.sub(r"\s+", " ", text).strip()

    return text
