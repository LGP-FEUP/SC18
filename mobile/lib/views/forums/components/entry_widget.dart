import 'package:erasmus_helper/models/forumEntry.dart';
import 'package:flutter/material.dart';

class ForumWidget extends StatelessWidget {
  final ForumEntry entry;

  const ForumWidget({Key? key, required this.entry}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Card(
      margin: const EdgeInsets.symmetric(vertical: 20),
      elevation: 4,
      color: Colors.white,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(24)),
      child: Padding(
          padding: const EdgeInsets.all(20),
          child: Column(
              crossAxisAlignment: CrossAxisAlignment.stretch,
              children: <Widget>[
                Padding(
                  padding: const EdgeInsets.only(bottom: 20),
                  child: ClipRRect(
                    borderRadius: BorderRadius.circular(30),
                    child: Image.asset(
                      entry.imagePath,
                      height: 150,
                      fit: BoxFit.fitWidth,
                    ),
                  ),
                ),
                Row(
                  children: <Widget>[
                    Expanded(
                      flex: 3,
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: <Widget>[
                          Text(entry.title),
                          SizedBox(
                            height: 15,
                          ),
                          /*Row(
                            children: <Widget>[
                              Icon(Icons.location_on),
                              SizedBox(
                                width: 5,
                              ),
                              Text(
                                entry.location,
                                textAlign: TextAlign.left,
                              ),
                            ],
                          )*/
                        ],
                      ),
                    ),
                    Expanded(
                      flex: 1,
                      child: Icon(Icons.more_horiz_rounded),
                    ),
                  ],
                )
              ])),
    );
  }
}
