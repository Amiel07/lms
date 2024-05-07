return (
    <div className="text-to-speech-container">
        <h1>Text-to-Speech <span>Converter</span></h1>
        <textarea className='text-to-speech-textarea'
            value={textToRead}
            onChange={handleInputChange}
            placeholder="Enter text to be spoken"
        />
        <h2>Play the Audio</h2>

        <div className="text-to-speech-controls">
            <button className='text-to-speech-speak-button' onClick={handleOnSubmit}>
                {isSpeaking ? 'Speaking...' : 'Speak'} <FaPlay />
            </button>

            {/* Render audio player */}
            {audioUrl && (
                <audio controls className="text-to-speech-audio-player">
                    <source src={audioUrl} type="audio/mpeg" />
                    Your browser does not support the audio element.
                </audio>
            )}
        </div>
    </div>
);